<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\ServiceRequest\ServiceRequestResource;
use App\Models\ServiceRequest;
use App\Models\Equipment;
use App\Models\NetworkMap;
use App\Services\Sysadmin\CoverageCheckService;
use App\Services\Sysadmin\ServiceRequestAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceRequestController extends Controller
{
    protected $coverageCheckService;
    protected $assignmentService;

    public function __construct(
        CoverageCheckService $coverageCheckService,
        ServiceRequestAssignmentService $assignmentService
    ) {
        $this->coverageCheckService = $coverageCheckService;
        $this->assignmentService = $assignmentService;
    }

    /**
     * Список заявок (на проверке и с привязанным оборудованием)
     */
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['providerClient', 'service', 'equipments'])
            ->whereIn('status', ['on_inspection', 'equipment_assigned', 'accepted', 'rejected'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['on_inspection', 'equipment_assigned']);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('installation_address', 'like', "%{$search}%")
                    ->orWhereHas('providerClient', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $requests = $query->paginate($request->per_page ?? 15)->withQueryString();

        return inertia('Sysadmin/ServiceRequest/Index', [
            'requests' => ServiceRequestResource::collection($requests),
            'filters' => $request->only(['search', 'status', 'date_from', 'date_to']),
            'services' => \App\Models\Service::select('id', 'name')->get(),
            'statistics' => [
                'on_inspection' => ServiceRequest::where('status', 'on_inspection')->count(),
                'equipment_assigned' => ServiceRequest::where('status', 'equipment_assigned')->count(),
            ]
        ]);
    }

    /**
     * Обновление статуса заявки
     */
    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'status' => 'required|in:on_inspection,accepted,rejected,archived',
        ]);

        $serviceRequest->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Статус обновлён');
    }

    /**
     * Детальная страница заявки
     */
    public function show(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'on_inspection') {
            return redirect()->route('sysadmin.service-requests.index')
                ->with('error', 'Эта заявка уже обработана');
        }

        $serviceRequest->load(['providerClient', 'service', 'equipments']);

        // Получаем оборудование, подходящее для услуги заявки (из справочника типов)
        $availableEquipment = Equipment::whereHas('services', function ($q) use ($serviceRequest) {
            $q->where('services.id', $serviceRequest->service_id);
        })->get();

        // Получаем узлы сети для карты (без привязки к оборудованию)
        $networkNodes = NetworkMap::all();

        return inertia('Sysadmin/ServiceRequest/Show', [
            'request' => new ServiceRequestResource($serviceRequest),
            'availableEquipment' => $availableEquipment,
            'networkNodes' => $networkNodes,
            'coverageCheck' => session('coverage_check'),
            'googleMapsApiKey' => config('services.google_maps.api_key'), // для Google Maps
        ]);
    }

    /**
     * Проверка покрытия для конкретной заявки
     */
    public function checkCoverage(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'address' => 'required|string|max:500'
        ]);

        $result = $this->coverageCheckService->checkByAddress($request->address);

        // Сохраняем результат в сессию для отображения на странице
        if ($result['success']) {
            // Если адрес в зоне покрытия, предлагаем подходящее оборудование
            if ($result['available']) {
                $result['recommended_equipment'] = $this->getRecommendedEquipment($serviceRequest);
            }
            session(['coverage_check' => $result]);
        }

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('coverage_check', $result);
    }

    /**
     * Получение рекомендуемого оборудования для услуги
     */
    private function getRecommendedEquipment(ServiceRequest $serviceRequest): array
    {
        return Equipment::whereHas('services', function ($q) use ($serviceRequest) {
            $q->where('services.id', $serviceRequest->service_id);
        })
            ->get()
            ->map(function ($equipment) {
                return [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'mac_address' => $equipment->mac_address,
                    'ip_address' => $equipment->ip_address,
                ];
            })
            ->toArray();
    }

    /**
     * Привязка оборудования к заявке (многие ко многим)
     */
    public function assignEquipment(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'equipment_ids' => 'required|array',
            'equipment_ids.*' => 'exists:equipment,id',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $serviceRequest->equipments()->sync($request->equipment_ids);
            $serviceRequest->update([
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
                'status' => 'equipment_assigned',
                'assignment_notes' => $request->notes
            ]);

            $this->assignmentService->notifyManager($serviceRequest);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('sysadmin.service-requests.index')
                ->with('success', 'Оборудование привязано к заявке');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Equipment assignment failed', [
                'request_id' => $serviceRequest->id,
                'error' => $e->getMessage()
            ]);

            $msg = 'Ошибка при привязке оборудования: ' . $e->getMessage();
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $msg], 422);
            }
            return back()->withErrors(['error' => $msg]);
        }
    }

    /**
     * Получение списка оборудования (все или по услуге)
     */
    public function getEquipmentOptions(Request $request, ServiceRequest $serviceRequest)
    {
        $serviceId = $request->query('service_id', $serviceRequest->service_id);

        $query = Equipment::query();
        if ($serviceId) {
            $query->whereHas('services', function ($q) use ($serviceId) {
                $q->where('services.id', $serviceId);
            });
        }
        $equipment = $query->orderBy('name')->get();

        return response()->json(['equipment' => $equipment]);
    }
}

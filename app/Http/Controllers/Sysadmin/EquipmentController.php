<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\NetworkMap;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Список оборудования (справочник типов)
     */
    public function index(Request $request)
    {
        $query = Equipment::with('services');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mac_address', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Важно: передаем параметры пагинации и сохраняем search в URL
        $equipment = $query->orderBy('name')->paginate(15)->appends($request->query());

        return inertia('Sysadmin/Equipment/Index', [
            'equipment' => $equipment,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        $services = \App\Models\Service::select('id', 'name')->get();
        return inertia('Sysadmin/Equipment/Create', ['services' => $services]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'mac_address' => 'nullable|string|max:255',
            'ip_address' => 'nullable|string|max:255',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $equipment = Equipment::create($request->only(['name', 'price', 'description', 'mac_address', 'ip_address']));

        if ($request->filled('service_ids')) {
            $equipment->services()->sync($request->service_ids);
        }

        return redirect()->route('sysadmin.equipment.index')->with('success', 'Оборудование добавлено');
    }

    /**
     * Страница редактирования оборудования
     */
    public function edit(Equipment $equipment)
    {
        $services = \App\Models\Service::select('id', 'name')->get();
        $equipment->load('services');

        return inertia('Sysadmin/Equipment/Edit', [
            'equipment' => $equipment,
            'services' => $services,
        ]);
    }

    /**
     * Обновление оборудования
     */
    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'mac_address' => 'nullable|string|max:255',
            'ip_address' => 'nullable|string|max:255',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $equipment->update($request->only(['name', 'price', 'description', 'mac_address', 'ip_address']));

        if ($request->filled('service_ids')) {
            $equipment->services()->sync($request->service_ids);
        } else {
            $equipment->services()->detach();
        }

        return redirect()->route('sysadmin.equipment.index')->with('success', 'Оборудование обновлено');
    }

    /**
     * Удаление оборудования
     */
    public function destroy(Equipment $equipment)
    {
        try {
            // Удаляем связи с услугами
            $equipment->services()->detach();
            // Удаляем оборудование
            $equipment->delete();

            return redirect()->back()->with('success', 'Оборудование удалено');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Не удалось удалить оборудование: ' . $e->getMessage());
        }
    }

    /**
     * Оборудование по узлу (узлы не привязаны к оборудованию — возвращаем всё)
     */
    public function getForNode(NetworkMap $node)
    {
        $equipment = Equipment::with('services')->get();

        return response()->json([
            'node' => $node->only(['id', 'name']),
            'equipment' => $equipment,
        ]);
    }

    /**
     * Toggle active — оборудование не имеет поля is_active (справочник типов)
     */
    public function toggleActive(Equipment $equipment)
    {
        return back()->with('info', 'Оборудование является справочником типов, изменение статуса недоступно.');
    }
}

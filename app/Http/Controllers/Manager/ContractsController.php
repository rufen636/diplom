<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ProviderClient;
use App\Models\ProviderDetail;
use App\Models\SampleContract;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContractsController extends Controller
{
    /**
     * Отобразить список договоров
     */
    public function index(Request $request): Response
    {
        $contracts = Contract::with('providerClient') // providerClient (единственное число)
        ->when($request->search, function ($query, $search) {
            $query->where('contract_number', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhereHas('providerClient', function ($q) use ($search) { // providerClient (единственное число)
                    $q->where('name', 'like', "%{$search}%");
                });
        })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Manager/Contracts/Index', [
            'contracts' => $contracts,
            'filters' => $request->only(['search', 'status']),
        ]);
    }
    /**
     * Показать форму создания договора
     */
    public function create(): Response
    {
        $users = User::select('id', 'name', 'email')->get();

        return Inertia::render('Manager/Contracts/Create', [
            'users' => $users,
        ]);
    }

    /**
     * Сохранить новый договор
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contract_number' => 'required|string|max:255|unique:contracts,contract_number',
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,terminated',
            'description' => 'nullable|string',
        ]);

        Contract::create($validated);

        return redirect()->route('manager.contracts.index')
            ->with('success', 'Договор успешно создан.');
    }

    /**
     * Показать форму редактирования договора
     */
    public function edit(Contract $contract): Response
    {
        $contract->load(['user', 'sampleContract']);
        $clients = ProviderClient::where('status', 'active')->get();
        $sampleContracts = SampleContract::where('status', 'active')->get(['id', 'name', 'contract_type']);

        return Inertia::render('Manager/Contracts/Edit', [
            'contract' => $contract,
            'clients' => $clients,
            'sampleContracts' => $sampleContracts,
        ]);
    }

    /**
     * Обновить договор
     */
    public function update(Request $request, Contract $contract): RedirectResponse
    {
        $validated = $request->validate([
            'contract_number' => 'required|string|max:255|unique:contracts,contract_number,' . $contract->id,
            'title' => 'required|string|max:255',
            'client_id' => 'required|numeric',
            'sample_id' => 'nullable|exists:sample_contracts,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,pending,not_paid,billing_issued',
            'description' => 'nullable|string',
        ]);

        $validated['sample_id'] = !empty($validated['sample_id']) ? $validated['sample_id'] : null;
        $contract->update($validated);

        return redirect()->route('manager.contracts.index')
            ->with('success', 'Договор успешно обновлен.');
    }
    public function updateDates(Request $request, Contract $contract)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $contract->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]);

        return response()->json(['message' => 'Даты договора обновлены']);
    }
    /**
     * Удалить договор
     */
    public function destroy(Contract $contract): RedirectResponse
    {
        $contract->delete();

        return redirect()->route('manager.contracts.index')
            ->with('success', 'Договор успешно удален.');
    }

    /**
     * Сгенерировать PDF договора из шаблона SampleContract и данных Contract
     */
    /**
     * Сгенерировать PDF договора из шаблона SampleContract и данных Contract
     */
    public function generatePdf(Contract $contract): \Illuminate\Http\Response
    {
        $contract->load(['providerClient.detail', 'sampleContract']);

        $organization = ProviderDetail::with('providerClient')->first();

        $pdf = Pdf::loadView('contract_pdf', [
            'contract' => $contract,
            'organization' => $organization,
        ]);

        return $pdf->stream('contract-' . $contract->id . '.pdf');
    }
}


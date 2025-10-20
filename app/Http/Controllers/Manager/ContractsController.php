<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ContractsController extends Controller
{
    /**
     * Отобразить список договоров
     */
    public function index(Request $request): Response
    {
        $contracts = Contract::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where('contract_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
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
        $contract->load('user');
        $users = User::select('id', 'name', 'email')->get();
        
        return Inertia::render('Manager/Contracts/Edit', [
            'contract' => $contract,
            'users' => $users,
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
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,terminated',
            'description' => 'nullable|string',
        ]);

        $contract->update($validated);

        return redirect()->route('manager.contracts.index')
            ->with('success', 'Договор успешно обновлен.');
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
}


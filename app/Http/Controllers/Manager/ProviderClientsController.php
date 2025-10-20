<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ProviderClient;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ProviderClientsController extends Controller
{
    /**
     * Отобразить список клиентов провайдера
     */
    public function index(Request $request): Response
    {
        $clients = ProviderClient::query()
            ->when($request->search, function ($query, $search) {
                $query->where('company_name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Manager/ProviderClients/Index', [
            'clients' => $clients,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Показать форму создания клиента
     */
    public function create(): Response
    {
        return Inertia::render('Manager/ProviderClients/Create');
    }

    /**
     * Сохранить нового клиента
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:provider_clients',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'inn' => 'nullable|string|max:20',
            'kpp' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,blocked',
            'notes' => 'nullable|string',
        ]);

        ProviderClient::create($validated);

        return redirect()->route('manager.provider-clients.index')
            ->with('success', 'Клиент провайдера успешно создан.');
    }

    /**
     * Показать форму редактирования клиента
     */
    public function edit(ProviderClient $providerClient): Response
    {
        return Inertia::render('Manager/ProviderClients/Edit', [
            'client' => $providerClient,
        ]);
    }

    /**
     * Обновить клиента
     */
    public function update(Request $request, ProviderClient $providerClient): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:provider_clients,email,' . $providerClient->id,
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'inn' => 'nullable|string|max:20',
            'kpp' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,blocked',
            'notes' => 'nullable|string',
        ]);

        $providerClient->update($validated);

        return redirect()->route('manager.provider-clients.index')
            ->with('success', 'Клиент провайдера успешно обновлен.');
    }

    /**
     * Удалить клиента
     */
    public function destroy(ProviderClient $providerClient): RedirectResponse
    {
        $providerClient->delete();

        return redirect()->route('manager.provider-clients.index')
            ->with('success', 'Клиент провайдера успешно удален.');
    }
}

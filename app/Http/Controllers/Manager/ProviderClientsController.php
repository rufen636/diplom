<?php

namespace App\Http\Controllers\Manager;

use App\Handlers\Manager\Client\ProviderClientHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\Client\ProviderClientRequest;
use App\Http\Resources\Manager\ProviderClient\ClientResource;
use App\Models\ProviderClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
        return Inertia::render('Manager/ProviderClients/Create',[]);
    }

    /**
     * Сохранить нового клиента
     */
    public function store(ProviderClientRequest $request, ProviderClientHandler $handler): RedirectResponse
    {
        $handler->handle($request->getDto());
        return to_route('manager.provider-clients.index');
    }

    /**
     * Показать форму редактирования клиента
     */
    public function edit(ProviderClient $providerClient): Response
    {
        $providerClient = ClientResource::make($providerClient)->resolve();
        dd($providerClient);
        return Inertia::render('Manager/ProviderClients/Edit', [
            'client' => $providerClient,
        ]);
    }

    /**
     * Обновить клиента
     */
    public function update(ProviderClientRequest $request, ProviderClientHandler $handler): RedirectResponse
    {
        $handler->handle($request->getDto());
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

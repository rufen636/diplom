<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TariffsController extends Controller
{
    /**
     * Отобразить список тарифов
     */
    public function index(Request $request): Response
    {
        $tariffs = Tariff::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->has('status'), function ($query) use ($request) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Manager/Tariffs/Index', [
            'tariffs' => $tariffs,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Показать форму создания тарифа
     */
    public function create(): Response
    {
        return Inertia::render('Manager/Tariffs/Create');
    }

    /**
     * Сохранить новый тариф
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'speed' => 'required|integer|min:1',
            'duration_months' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Tariff::create($validated);

        return redirect()->route('manager.tariffs.index')
            ->with('success', 'Тариф успешно создан.');
    }

    /**
     * Показать форму редактирования тарифа
     */
    public function edit(Tariff $tariff): Response
    {
        return Inertia::render('Manager/Tariffs/Edit', [
            'tariff' => $tariff,
        ]);
    }

    /**
     * Обновить тариф
     */
    public function update(Request $request, Tariff $tariff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'speed' => 'required|integer|min:1',
            'duration_months' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $tariff->update($validated);

        return redirect()->route('manager.tariffs.index')
            ->with('success', 'Тариф успешно обновлен.');
    }

    /**
     * Удалить тариф
     */
    public function destroy(Tariff $tariff): RedirectResponse
    {
        $tariff->delete();

        return redirect()->route('manager.tariffs.index')
            ->with('success', 'Тариф успешно удален.');
    }
}

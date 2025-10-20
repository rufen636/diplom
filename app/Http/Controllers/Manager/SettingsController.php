<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    /**
     * Отобразить страницу настроек
     */
    public function index(): Response
    {
        return Inertia::render('Manager/Settings', [
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => app()->version(),
            'environment' => config('app.env'),
        ]);
    }

    /**
     * Обновить настройки
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'maintenance_mode' => 'boolean',
        ]);

        // Здесь можно сохранить настройки в конфиг или БД
        // config(['app.name' => $validated['site_name']]);

        return redirect()->route('manager.settings.index')
            ->with('success', 'Настройки успешно обновлены.');
    }
}


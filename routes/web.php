<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\UsersController;
use App\Http\Controllers\Manager\ContractsController;
use App\Http\Controllers\Manager\TariffsController;
use App\Http\Controllers\Manager\ProviderClientsController;
use App\Http\Controllers\Manager\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Роуты для менеджера
Route::middleware(['auth', 'verified'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Управление договорами
    Route::get('/contracts', [ContractsController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [ContractsController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractsController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [ContractsController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [ContractsController::class, 'update'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [ContractsController::class, 'destroy'])->name('contracts.destroy');

    // Управление тарифами
    Route::get('/tariffs', [TariffsController::class, 'index'])->name('tariffs.index');
    Route::get('/tariffs/create', [TariffsController::class, 'create'])->name('tariffs.create');
    Route::post('/tariffs', [TariffsController::class, 'store'])->name('tariffs.store');
    Route::get('/tariffs/{tariff}/edit', [TariffsController::class, 'edit'])->name('tariffs.edit');
    Route::put('/tariffs/{tariff}', [TariffsController::class, 'update'])->name('tariffs.update');
    Route::delete('/tariffs/{tariff}', [TariffsController::class, 'destroy'])->name('tariffs.destroy');

    // Управление клиентами провайдера
    Route::get('/provider-clients', [ProviderClientsController::class, 'index'])->name('provider-clients.index');
    Route::get('/provider-clients/create', [ProviderClientsController::class, 'create'])->name('provider-clients.create');
    Route::post('/provider-clients', [ProviderClientsController::class, 'store'])->name('provider-clients.store');
    Route::get('/provider-clients/{providerClient}/edit', [ProviderClientsController::class, 'edit'])->name('provider-clients.edit');
    Route::put('/provider-clients/{providerClient}', [ProviderClientsController::class, 'update'])->name('provider-clients.update');
    Route::delete('/provider-clients/{providerClient}', [ProviderClientsController::class, 'destroy'])->name('provider-clients.destroy');

    // Настройки
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';

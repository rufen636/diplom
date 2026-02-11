<?php

use App\Http\Controllers\Manager\ServiceRequestController;
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

// Роуты для менеджера
Route::group([
    'prefix' => 'manager',
    'as' => 'manager.',
    'middleware' => ['auth', 'verified', 'role:sysadmin']
], function () {
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
    Route::resource('/provider-clients', ProviderClientsController::class);
    Route::resource('/requests', ServiceRequestController::class);
    // Настройки
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';

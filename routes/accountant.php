<?php

use App\Http\Controllers\Buh\BillingController;
use App\Http\Controllers\Buh\ActController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Роуты для менеджера
Route::group([
    'prefix' => 'accountant',
    'as' => 'accountant.',
    'middleware' => ['auth', 'verified', 'role:buh']
], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Buh\DashboardController::class, 'index'])->name('dashboard');


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
    Route::get('/', fn () => redirect()->route('accountant.billing.index'))->name('dashboard');
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/create', [BillingController::class, 'create'])->name('billing.create');
    Route::post('/billing', [BillingController::class, 'store'])->name('billing.store');
    Route::patch('/billing/{billing}/status', [BillingController::class, 'updateStatus'])->name('billing.updateStatus');

    Route::get('/acts', [ActController::class, 'index'])->name('acts.index');
    Route::get('/acts/generate', [ActController::class, 'create'])->name('acts.create');
    Route::post('/acts/generate', [ActController::class, 'generateActs'])->name('acts.generate');
});

require __DIR__.'/auth.php';

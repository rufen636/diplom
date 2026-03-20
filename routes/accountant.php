<?php

use App\Http\Controllers\Buh\BillingController;
use App\Http\Controllers\Buh\ActController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'accountant',
    'as' => 'accountant.',
    'middleware' => ['auth', 'verified', 'role:buh']
], function () {
    Route::get('/', fn () => redirect()->route('accountant.billing.index'))->name('dashboard');
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/create', [BillingController::class, 'create'])->name('billing.create');
    Route::post('/billing', [BillingController::class, 'store'])->name('billing.store');
    Route::patch('/billing/{billing}/status', [BillingController::class, 'updateStatus'])->name('billing.updateStatus');

    Route::get('/acts', [ActController::class, 'index'])->name('acts.index');
    Route::get('/acts/generate', [ActController::class, 'create'])->name('acts.create');
    Route::post('/acts/generate', [ActController::class, 'generateActs'])->name('acts.generate');
});

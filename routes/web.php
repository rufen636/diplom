<?php

use App\Http\Controllers\Manager\ServiceRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\UsersController;
use App\Http\Controllers\Manager\ContractsController;
use App\Http\Controllers\Manager\TariffsController;
use App\Http\Controllers\Manager\ProviderClientsController;
use App\Http\Controllers\Manager\SettingsController;
use App\Http\Resources\Manager\Provider\ProviderDetailResource;
use App\Models\ProviderDetail;
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
    return Inertia::render('Dashboard',['role' => auth()->user()->getRoleNames()->first() ?? 'user']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
require __DIR__.'/manager.php';
require __DIR__ . '/sysadmin.php';

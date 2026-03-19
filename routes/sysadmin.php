<?php


use App\Http\Controllers\Manager\SettingsController;
use App\Http\Controllers\Manager\UsersController;
use App\Http\Controllers\Sysadmin\CoveragePointController;
use App\Http\Controllers\Sysadmin\DashboardController;
use App\Http\Controllers\Sysadmin\EquipmentController;
use App\Http\Controllers\Sysadmin\NetworkMapController;
use App\Http\Controllers\Sysadmin\ServiceRequestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Роуты для менеджера
Route::group([
    'prefix' => 'sysadmin',
    'as' => 'sysadmin.',
    'middleware' => ['auth', 'verified', 'role:sysadmin']
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Заявки на проверке
    Route::get('/service-requests', [ServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::get('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('service-requests.show');
    Route::patch('/service-requests/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])->name('service-requests.update-status');
    Route::post('/service-requests/{serviceRequest}/check-coverage', [ServiceRequestController::class, 'checkCoverage'])->name('service-requests.check-coverage');
    Route::post('/service-requests/{serviceRequest}/assign-equipment', [ServiceRequestController::class, 'assignEquipment'])->name('service-requests.assign-equipment');
    Route::get('/service-requests/{serviceRequest}/equipment-options', [ServiceRequestController::class, 'getEquipmentOptions'])->name('service-requests.equipment-options');

    // Карта покрытия
    Route::get('/network-map', [NetworkMapController::class, 'index'])->name('network-map.index');
    Route::post('/check-coverage-by-address', [NetworkMapController::class, 'checkCoverageByAddress'])->name('check-coverage-by-address');
    Route::get('/network-map/{node}/details', [NetworkMapController::class, 'getNodeDetails'])->name('network-map.details');
         Route::get('/coverage-points', [CoveragePointController::class, 'index'])->name('coverage-points.index');
        Route::post('/coverage-points', [CoveragePointController::class, 'store'])->name('coverage-points.store');
        Route::put('/coverage-points/{id}', [CoveragePointController::class, 'update'])->name('coverage-points.update');
        Route::delete('/coverage-points/{id}', [CoveragePointController::class, 'destroy'])->name('coverage-points.destroy');
        Route::post('/check-coverage-by-address', [CoveragePointController::class, 'checkByAddress'])->name('check-coverage-by-address');

    // Оборудование
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::post('/equipment', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::get('/equipment/for-node/{node}', [EquipmentController::class, 'getForNode'])->name('equipment.for-node');
    Route::post('/equipment/{equipment}/toggle-active', [EquipmentController::class, 'toggleActive'])->name('equipment.toggle-active');
    // Настройки
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';

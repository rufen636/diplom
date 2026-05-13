<?php

use App\Http\Controllers\Api\TariffApiController;
use App\Http\Controllers\Buh\ActController;
use App\Http\Controllers\Manager\ProviderClientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/provider-clients', ProviderClientsController::class);

Route::get('/acts', [ActController::class, 'indexApi'])->name('acts.index.api');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/tariffs', [TariffApiController::class, 'index']);
    Route::post('/tariffs', [TariffApiController::class, 'store']);
    Route::patch('/tariffs/{tariff}', [TariffApiController::class, 'update']);
    Route::delete('/tariffs/{tariff}', [TariffApiController::class, 'destroy']);
});

<?php

use App\Http\Controllers\Buh\ActController;
use App\Http\Controllers\Manager\ProviderClientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/provider-clients', ProviderClientsController::class);

Route::get('/acts',[ActController::class,'indexApi'])->name('acts.index.api');

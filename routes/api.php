<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PhoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('guests',GuestController::class) //cria rotas para cada um dos métodos
->middleware(['auth:sanctum']); 

Route::apiResource('guests.phones', PhoneController::class);
// dependencia de guest.id para crud do(s) seu(s) respectivo(s) telefone(s)
// php artisan route:list para listá-las

Route::apiResource('guests.addresses', AddressController::class);
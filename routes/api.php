<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user()->load('guest');
});

Route::apiResource('guests',GuestController::class) //cria rotas para cada um dos métodos
->middleware(['auth:sanctum']); 

Route::apiResource('guests.phones', PhoneController::class);
// dependencia de guest.id para crud do(s) seu(s) respectivo(s) telefone(s)
// php artisan route:list para listá-las

Route::apiResource('guests.addresses', AddressController::class);

Route::apiResource('reservations', ReservationController::class);

Route::post('reservations/{reservation}/guests/{guest}/add-guest', [ReservationController::class, 'addGuest']);

// Rota para o check-in de um hóspede
Route::post('reservations/{reservation}/guests/{guest}/checkin', [ReservationController::class, 'checkIn']);
    
// Rota para o check-out de um hóspede
Route::post('reservations/{reservation}/guests/{guest}/checkout', [ReservationController::class, 'checkOut']);

// Rota para atualizar o tipo de um hóspede
Route::post('reservations/{reservation}/guests/{guest}/updateType', [ReservationController::class, 'updateType']);
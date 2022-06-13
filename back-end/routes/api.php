<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clinicaController;

Route::get('/specialtiy', [clinicaController::class, 'index']);
Route::get('/how-did-you-meet-us', [clinicaController::class, 'getHowDidYouMeetUs']);
Route::get('/professional/specialtiy/{id}', [clinicaController::class, 'getById']);
Route::post('/clinica/appointment', [clinicaController::class, 'store']);
Route::get('/clinica/appointment', [clinicaController::class, 'listAppointments']);



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('gestion');
}); 

Route::get('/api/clients', [ClientController::class, 'index']);

// Routes d'authentification
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


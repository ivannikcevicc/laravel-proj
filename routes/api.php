<?php

use Illuminate\Support\Facades\Route; // Add this line to import Route
use App\Http\Controllers\LoginController;

// Define your routes
Route::post('/login', [LoginController::class, 'submit']);
Route::post('/login/verify', [LoginController::class, 'verify']);

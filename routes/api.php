<?php

use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route; // Add this line to import Route
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;

// Define your routes
Route::post('/login', [LoginController::class, 'submit']);
Route::post('/login/verify', [LoginController::class, 'verify']);



Route::group(['middleware' => 'auth:sanctum'], function () {

  Route::get('/driver', [DriverController::class, 'show']);
  Route::post('/driver', [DriverController::class, 'update']);
  Route::post('/trip', [TripController::class, 'store']);
  Route::get('/trip/{trip}', [TripController::class, 'show']);
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
});

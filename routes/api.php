<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/prueba', [ApiController::class, 'get']);
Route::post('/prueba', [ApiController::class, 'post']);
Route::put('/prueba', [ApiController::class, 'put']);
Route::patch('/prueba', [ApiController::class, 'patch']);
Route::delete('/prueba', [ApiController::class, 'delete']);

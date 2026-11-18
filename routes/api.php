<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AlumnosApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/prueba', [ApiController::class, 'get']);
Route::post('/prueba', [ApiController::class, 'post']);
Route::put('/prueba', [ApiController::class, 'put']);
Route::patch('/prueba', [ApiController::class, 'patch']);
Route::delete('/prueba', [ApiController::class, 'delete']);

Route::get('/alumnos', [AlumnosApiController::class, 'readAll']);
Route::get('/alumnos/{id}', [AlumnosApiController::class, 'readOne']);
Route::post('/alumnos', [AlumnosApiController::class, 'store']);
Route::put('/alumnos/{id}', [AlumnosApiController::class, 'update']);
Route::patch('/alumnos/{id}/toggle-active', [AlumnosApiController::class, 'toggleActive']);
Route::delete('/alumnos/{id}', [AlumnosApiController::class, 'delete']);
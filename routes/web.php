<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profesores', function () {
    return view('profesores');
});

Route::get('/alumnos', [AlumnoController::class, 'index']);
Route::post('/alumnos', [AlumnoController::class, 'store']);
Route::put('/alumnos/{alumno}', [AlumnoController::class, 'update']);
Route::patch('/alumnos/{alumno}/activo', [AlumnoController::class, 'toggleActivo']);
Route::delete('/alumnos/{alumno}', [AlumnoController::class, 'destroy']);

Route::get('/admin', function () {
    return 'Bienvenido al panel administrativo';
})->middleware('verificar.acceso');

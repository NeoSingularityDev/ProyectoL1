<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profesores', function () {
    return view('profesores');
});

Route::get('/alumnos', [AlumnoController::class, 'index']); //Select que retorna vista con datos
Route::post('/alumnos', [AlumnoController::class, 'store']); // Insert
Route::put('/alumnos/{alumno}', [AlumnoController::class, 'update']); // Update
Route::patch('/alumnos/{alumno}/activo', [AlumnoController::class, 'toggleActivo']); // Update pero limitado de campos
Route::delete('/alumnos/{alumno}', [AlumnoController::class, 'destroy']); // Delete

Route::get('/admin', function () {
    return 'Bienvenido al panel administrativo';
})->middleware('verificar.acceso'); // No toquen esto, es de satanas y aun no lo ven

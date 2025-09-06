<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\EpsController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\MedicosController;
use App\Http\Controllers\PacientesController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('eps', [EpsController::class, 'index']);
        Route::post('eps', [EpsController::class, 'store']);
        Route::put('eps/{id}', [EpsController::class, 'update']);
        Route::delete('eps/{id}', [EpsController::class, 'destroy']);
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
        Route::post('especialidades', [EspecialidadesController::class, 'store']);
        Route::put('especialidades/{id}', [EspecialidadesController::class, 'update']);
        Route::delete('especialidades/{id}', [EspecialidadesController::class, 'destroy']);
        Route::get('medicos', [MedicosController::class, 'index']);
        Route::post('medicos', [MedicosController::class, 'store']);
        Route::put('medicos/{id}', [MedicosController::class, 'update']);
        Route::delete('medicos/{id}', [MedicosController::class, 'destroy']);
        Route::get('pacientes', [PacientesController::class, 'index']);
        Route::post('pacientes', [PacientesController::class, 'store']);
        Route::put('pacientes/{id}', [PacientesController::class, 'update']);
        Route::delete('pacientes/{id}', [PacientesController::class, 'destroy']);
        Route::get('citas', [CitasController::class, 'index']);
        Route::post('citas', [CitasController::class, 'store']);
        Route::put('citas/{id}', [CitasController::class, 'update']);
        Route::delete('citas/{id}', [CitasController::class, 'destroy']);
    });

Route::middleware(['auth:sanctum', 'role:medico'])->group(function () {
        Route::get('citas', [CitasController::class, 'index']);
        Route::put('citas/{id}', [CitasController::class, 'update']);
        Route::delete('citas/{id}', [CitasController::class, 'destroy']);
        Route::get('pacientes', [PacientesController::class, 'index']);
        Route::get('pacientes/{id}', [PacientesController::class, 'show']);
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
    });

Route::middleware(['auth:sanctum', 'role:paciente'])->group(function () {
        Route::get('citas', [CitasController::class, 'index']);
        Route::post('citas', [CitasController::class, 'store']);
        Route::put('citas/{id}', [CitasController::class, 'update']);
        Route::delete('citas/{id}', [CitasController::class, 'destroy']);
        Route::get('medicos', [MedicosController::class, 'index']);
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
    });
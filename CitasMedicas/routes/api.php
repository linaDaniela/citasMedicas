<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpsController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\MedicosController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ConsultoriosController;
use App\Http\Controllers\HistorialMedicoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-paciente', [AuthController::class, 'registerPaciente']);

// Rutas públicas para consultas
Route::get('/public/eps', [EpsController::class, 'index']);
Route::get('/public/especialidades', [EspecialidadesController::class, 'index']);
Route::get('/public/consultorios', [ConsultoriosController::class, 'index']);
Route::get('/public/medicos', [MedicosController::class, 'index']);

// Rutas temporales para debugging (SOLO PARA DESARROLLO)
Route::get('/debug/medicos', [AuthController::class, 'debugMedicos']);
Route::get('/debug/admins', [AuthController::class, 'debugAdmins']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas para administradores
    Route::middleware('admin')->group(function () {
        Route::post('/crear-medico', [AuthController::class, 'crearMedico']);
        Route::post('/crear-administrador', [AuthController::class, 'crearAdministrador']);

        // CRUD completo
        Route::apiResource('eps', EpsController::class);
        Route::apiResource('especialidades', EspecialidadesController::class);
        Route::apiResource('consultorios', ConsultoriosController::class);
        Route::apiResource('medicos', MedicosController::class);
        Route::apiResource('pacientes', PacientesController::class);
        Route::apiResource('citas', CitasController::class);

        // Relaciones
        Route::get('/eps/{eps}/pacientes', [EpsController::class, 'pacientes']);
        Route::get('/especialidades/{especialidad}/medicos', [EspecialidadesController::class, 'medicos']);
        Route::get('/consultorios/{consultorio}/citas', [ConsultoriosController::class, 'citas']);
        Route::get('/medicos/{medico}/citas', [MedicosController::class, 'citas']);
        Route::get('/medicos/{medico}/pacientes', [MedicosController::class, 'pacientes']);
        Route::get('/pacientes/{paciente}/citas', [PacientesController::class, 'citas']);
        Route::get('/pacientes/{paciente}/historial', [PacientesController::class, 'historial']);
    });

    // Rutas para médicos
    Route::middleware('role:medico')->group(function () {
        Route::get('/medico/citas', [CitasController::class, 'misCitas']);
        Route::get('/medico/pacientes', [PacientesController::class, 'misPacientes']);
        Route::post('/medico/citas/{cita}/completar', [CitasController::class, 'completarCita']);
        Route::apiResource('historial-medico', HistorialMedicoController::class);
    });

    // Rutas para pacientes
    Route::middleware('role:paciente')->group(function () {
        Route::get('/paciente/citas', [CitasController::class, 'misCitas']);
        Route::post('/paciente/citas', [CitasController::class, 'store']);
        Route::put('/paciente/citas/{cita}', [CitasController::class, 'update']);
        Route::delete('/paciente/citas/{cita}', [CitasController::class, 'cancelar']);
        Route::get('/paciente/historial', [HistorialMedicoController::class, 'miHistorial']);
    });

    // Rutas comunes para usuarios autenticados
    Route::get('/eps', [EpsController::class, 'index']);
    Route::get('/especialidades', [EspecialidadesController::class, 'index']);
    Route::get('/consultorios', [ConsultoriosController::class, 'index']);
    Route::get('/medicos', [MedicosController::class, 'index']);
    Route::get('/medicos/{especialidad}', [MedicosController::class, 'porEspecialidad']);
    Route::get('/citas/disponibles', [CitasController::class, 'horariosDisponibles']);
    Route::get('/citas/estados', [CitasController::class, 'estados']);

    // Búsquedas
    Route::get('/buscar/pacientes', [PacientesController::class, 'buscar']);
    Route::get('/buscar/medicos', [MedicosController::class, 'buscar']);
    Route::get('/buscar/citas', [CitasController::class, 'buscar']);
    Route::get('/filtros/citas', [CitasController::class, 'filtros']);
});

// Ruta de salud del sistema
Route::get('/health', [AuthController::class, 'health']);
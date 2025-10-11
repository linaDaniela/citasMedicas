<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AdministradorController;

// ==========================
// 🔹 RUTA DE PRUEBA
// ==========================
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'Conexión exitosa con la API',
        'timestamp' => now(),
        'server' => 'Laravel API funcionando correctamente'
    ]);
});

// ==========================
// 🔹 AUTENTICACIÓN
// ==========================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/paciente', [AuthController::class, 'registerPaciente']);

// ==========================
// 🔹 RUTAS DE PERFIL
// ==========================
Route::put('/profile/update', [AuthController::class, 'updateProfile']);
Route::put('/profile/change-password', [AuthController::class, 'changePassword']);

// ==========================
// 🔹 RUTAS PÚBLICAS (SIN AUTENTICACIÓN)
// ==========================
Route::get('/especialidades', [EspecialidadController::class, 'index']);

// ==========================
// 🔹 RUTAS SIN AUTENTICACIÓN (TEMPORAL)
// ==========================
// Médicos (CRUD completo sin autenticación)
Route::get('/medicos', [MedicoController::class, 'index']);
Route::get('/medicos/{id}', [MedicoController::class, 'show']);
Route::post('/medicos', [MedicoController::class, 'store']);
Route::put('/medicos/{id}', [MedicoController::class, 'update']);
Route::delete('/medicos/{id}', [MedicoController::class, 'destroy']);

// Pacientes (CRUD completo sin autenticación)
Route::get('/pacientes', [PacienteController::class, 'index']);
Route::get('/pacientes/{id}', [PacienteController::class, 'show']);
Route::post('/pacientes', [PacienteController::class, 'store']);
Route::put('/pacientes/{id}', [PacienteController::class, 'update']);
Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy']);

// Especialidades (CRUD completo sin autenticación)
Route::post('/especialidades', [EspecialidadController::class, 'store']);
Route::put('/especialidades/{id}', [EspecialidadController::class, 'update']);
Route::delete('/especialidades/{id}', [EspecialidadController::class, 'destroy']);

// Citas (CRUD completo sin autenticación)
Route::get('/citas', [CitaController::class, 'index']);
Route::get('/citas/{id}', [CitaController::class, 'show']);
Route::post('/citas', [CitaController::class, 'store']);
Route::put('/citas/{id}', [CitaController::class, 'update']);
Route::delete('/citas/{id}', [CitaController::class, 'destroy']);

// Administradores (CRUD completo sin autenticación)
Route::get('/administradores', [AdministradorController::class, 'index']);
Route::get('/administradores/{id}', [AdministradorController::class, 'show']);
Route::post('/administradores', [AdministradorController::class, 'store']);
Route::put('/administradores/{id}', [AdministradorController::class, 'update']);
Route::delete('/administradores/{id}', [AdministradorController::class, 'destroy']);

// ==========================
// 🔹 RUTAS ESPECÍFICAS PARA MÉDICOS
// ==========================
Route::prefix('medico')->group(function () {
    Route::get('/mis-citas', [MedicoController::class, 'getMisCitas']);
    Route::get('/mis-pacientes', [MedicoController::class, 'getMisPacientes']);
    Route::get('/mi-agenda', [MedicoController::class, 'getMiAgenda']);
    Route::get('/reportes', [MedicoController::class, 'getReportes']);
    Route::put('/citas/{id}/estado', [MedicoController::class, 'actualizarEstadoCita']);
    Route::put('/citas/{id}/observaciones', [MedicoController::class, 'agregarObservaciones']);
});

// ==========================
// 🔹 RUTAS ESPECÍFICAS PARA PACIENTES
// ==========================
Route::prefix('paciente')->group(function () {
    Route::get('/mis-citas', [PacienteController::class, 'getMisCitas']);
    Route::get('/proxima-cita', [PacienteController::class, 'getProximaCita']);
    Route::post('/agendar-cita', [PacienteController::class, 'agendarCita']);
    Route::put('/citas/{id}/cancelar', [PacienteController::class, 'cancelarCita']);
    Route::get('/mi-historial', [PacienteController::class, 'getMiHistorial']);
    Route::get('/medicos-disponibles', [MedicoController::class, 'index']);
});

// ==========================
// 🔹 RUTAS ESPECÍFICAS PARA ADMIN (SIN AUTENTICACIÓN TEMPORAL)
// ==========================
Route::prefix('admin')->group(function () {
    Route::get('/citas', [CitaController::class, 'index']);
    Route::get('/medicos', [MedicoController::class, 'index']);
    Route::get('/pacientes', [PacienteController::class, 'index']);
    Route::get('/administradores', [AdministradorController::class, 'index']);
    Route::get('/estadisticas', [AdministradorController::class, 'getEstadisticas']);
});

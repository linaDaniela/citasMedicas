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
use App\Http\Controllers\MedicamentosController;
use App\Http\Controllers\RecetasMedicasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-paciente', [AuthController::class, 'registerPaciente']);

// Rutas públicas para consultas
Route::get('/public/eps', [EpsController::class, 'index']);
Route::get('/public/especialidades', [EspecialidadesController::class, 'index']);
Route::get('/public/consultorios', [ConsultoriosController::class, 'index']);
Route::get('/public/medicos', [MedicosController::class, 'index']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Información del usuario autenticado
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rutas para administradores
    Route::middleware('admin')->group(function () {
        Route::post('/crear-medico', [AuthController::class, 'crearMedico']);
        Route::post('/crear-administrador', [AuthController::class, 'crearAdministrador']);
        
        // CRUD completo para administradores
        Route::apiResource('eps', EpsController::class);
        Route::apiResource('especialidades', EspecialidadesController::class);
        Route::apiResource('consultorios', ConsultoriosController::class);
        Route::apiResource('medicos', MedicosController::class);
        Route::apiResource('pacientes', PacientesController::class);
        Route::apiResource('citas', CitasController::class);
        Route::apiResource('medicamentos', MedicamentosController::class);
        Route::apiResource('recetas-medicas', RecetasMedicasController::class);
    });
    
    // Rutas para médicos
    Route::middleware('medico')->group(function () {
        Route::get('/medico/citas', [CitasController::class, 'misCitas']);
        Route::get('/medico/pacientes', [PacientesController::class, 'misPacientes']);
        Route::post('/medico/citas/{cita}/completar', [CitasController::class, 'completarCita']);
        Route::apiResource('historial-medico', HistorialMedicoController::class);
    });
    
    // Rutas para pacientes
    Route::middleware('paciente')->group(function () {
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
});

// Ruta de prueba
Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente',
        'timestamp' => now(),
        'version' => '2.0.0'
    ]);
});
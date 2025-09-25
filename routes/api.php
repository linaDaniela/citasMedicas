<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ConsultoriosController;
use App\Http\Controllers\DetalleRecetasController;
use App\Http\Controllers\EpsController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\HistorialMedicoController;
use App\Http\Controllers\MedicamentosController;
use App\Http\Controllers\MedicosController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\RecetasMedicasController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Consultas públicas (sin autenticación)
Route::get('/public/eps', [EpsController::class, 'index']);
Route::get('/public/especialidades', [EspecialidadesController::class, 'index']);
Route::get('/public/medicos', [MedicosController::class, 'index']);
Route::get('/public/consultorios', [ConsultoriosController::class, 'index']);                       

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        // EPS
        Route::get('eps', [EpsController::class, 'index']);
        Route::post('eps', [EpsController::class, 'store']);
        Route::get('eps/{id}', [EpsController::class, 'show']);
        Route::put('eps/{id}', [EpsController::class, 'update']);
        Route::delete('eps/{id}', [EpsController::class, 'destroy']);
        
        // Especialidades
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
        Route::post('especialidades', [EspecialidadesController::class, 'store']);
        Route::get('especialidades/{id}', [EspecialidadesController::class, 'show']);
        Route::put('especialidades/{id}', [EspecialidadesController::class, 'update']);
        Route::delete('especialidades/{id}', [EspecialidadesController::class, 'destroy']);
        
        // Consultorios
        Route::get('consultorios', [ConsultoriosController::class, 'index']);
        Route::post('consultorios', [ConsultoriosController::class, 'store']);
        Route::get('consultorios/{id}', [ConsultoriosController::class, 'show']);
        Route::put('consultorios/{id}', [ConsultoriosController::class, 'update']);
        Route::delete('consultorios/{id}', [ConsultoriosController::class, 'destroy']);
        
        // Médicos
        Route::get('medicos', [MedicosController::class, 'index']);
        Route::post('medicos', [MedicosController::class, 'store']);
        Route::get('medicos/{id}', [MedicosController::class, 'show']);
        Route::put('medicos/{id}', [MedicosController::class, 'update']);
        Route::delete('medicos/{id}', [MedicosController::class, 'destroy']);
        
        // Pacientes
        Route::get('pacientes', [PacientesController::class, 'index']);
        Route::post('pacientes', [PacientesController::class, 'store']);
        Route::get('pacientes/{id}', [PacientesController::class, 'show']);
        Route::put('pacientes/{id}', [PacientesController::class, 'update']);
        Route::delete('pacientes/{id}', [PacientesController::class, 'destroy']);
        
        // Citas
        Route::get('citas', [CitasController::class, 'index']);
        Route::post('citas', [CitasController::class, 'store']);
        Route::get('citas/{id}', [CitasController::class, 'show']);
        Route::put('citas/{id}', [CitasController::class, 'update']);
        Route::delete('citas/{id}', [CitasController::class, 'destroy']);
        
        // Medicamentos
        Route::get('medicamentos', [MedicamentosController::class, 'index']);
        Route::post('medicamentos', [MedicamentosController::class, 'store']);
        Route::get('medicamentos/{id}', [MedicamentosController::class, 'show']);
        Route::put('medicamentos/{id}', [MedicamentosController::class, 'update']);
        Route::delete('medicamentos/{id}', [MedicamentosController::class, 'destroy']);
        
        // Recetas Médicas
        Route::get('recetas-medicas', [RecetasMedicasController::class, 'index']);
        Route::post('recetas-medicas', [RecetasMedicasController::class, 'store']);
        Route::get('recetas-medicas/{id}', [RecetasMedicasController::class, 'show']);
        Route::put('recetas-medicas/{id}', [RecetasMedicasController::class, 'update']);
        Route::delete('recetas-medicas/{id}', [RecetasMedicasController::class, 'destroy']);
        
        // Historial Médico
        Route::get('historial-medico', [HistorialMedicoController::class, 'index']);
        Route::post('historial-medico', [HistorialMedicoController::class, 'store']);
        Route::get('historial-medico/{id}', [HistorialMedicoController::class, 'show']);
        Route::put('historial-medico/{id}', [HistorialMedicoController::class, 'update']);
        Route::delete('historial-medico/{id}', [HistorialMedicoController::class, 'destroy']);
        Route::get('historial-medico/paciente/{pacienteId}', [HistorialMedicoController::class, 'getByPaciente']);
    });

Route::middleware(['auth:sanctum', 'role:medico'])->group(function () {
        // Citas
        Route::get('citas', [CitasController::class, 'index']);
        Route::get('citas/{id}', [CitasController::class, 'show']);
        Route::put('citas/{id}', [CitasController::class, 'update']);
        
        // Pacientes
        Route::get('pacientes', [PacientesController::class, 'index']);
        Route::get('pacientes/{id}', [PacientesController::class, 'show']);
        
        // Especialidades
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
        
        // Historial Médico
        Route::get('historial-medico', [HistorialMedicoController::class, 'index']);
        Route::post('historial-medico', [HistorialMedicoController::class, 'store']);
        Route::get('historial-medico/{id}', [HistorialMedicoController::class, 'show']);
        Route::put('historial-medico/{id}', [HistorialMedicoController::class, 'update']);
        Route::get('historial-medico/paciente/{pacienteId}', [HistorialMedicoController::class, 'getByPaciente']);
        
        // Recetas Médicas
        Route::get('recetas-medicas', [RecetasMedicasController::class, 'index']);
        Route::post('recetas-medicas', [RecetasMedicasController::class, 'store']);
        Route::get('recetas-medicas/{id}', [RecetasMedicasController::class, 'show']);
        Route::put('recetas-medicas/{id}', [RecetasMedicasController::class, 'update']);
        
        // Medicamentos
        Route::get('medicamentos', [MedicamentosController::class, 'index']);
        Route::get('medicamentos/{id}', [MedicamentosController::class, 'show']);
    });

Route::middleware(['auth:sanctum', 'role:paciente'])->group(function () {
        // Citas
        Route::get('citas', [CitasController::class, 'index']);
        Route::post('citas', [CitasController::class, 'store']);
        Route::get('citas/{id}', [CitasController::class, 'show']);
        Route::put('citas/{id}', [CitasController::class, 'update']);
        Route::delete('citas/{id}', [CitasController::class, 'destroy']);
        
        // Médicos
        Route::get('medicos', [MedicosController::class, 'index']);
        Route::get('medicos/{id}', [MedicosController::class, 'show']);
        
        // Especialidades
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
        
        // EPS
        Route::get('eps', [EpsController::class, 'index']);
        Route::get('eps/{id}', [EpsController::class, 'show']);
        
        // Historial Médico (solo lectura)
        Route::get('historial-medico/paciente/{pacienteId}', [HistorialMedicoController::class, 'getByPaciente']);
        
        // Recetas Médicas (solo lectura)
        Route::get('recetas-medicas', [RecetasMedicasController::class, 'index']);
        Route::get('recetas-medicas/{id}', [RecetasMedicasController::class, 'show']);
    });
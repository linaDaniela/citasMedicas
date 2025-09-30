<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Medicos;
use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Login unificado para todos los tipos de usuarios
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
                'tipo_usuario' => 'required|string|in:administrador,medico,paciente'
            ]);

            $user = null;
            $tipo = $request->tipo_usuario;
            $email = $request->email;

            Log::info('🔐 Intento de login', [
                'email' => $email,
                'tipo_usuario' => $tipo,
                'timestamp' => now()
            ]);

            // Buscar usuario según el tipo (por email o usuario)
            switch ($tipo) {
                case 'administrador':
                    $user = Administrador::where(function($query) use ($email) {
                        $query->where('email', $email)
                              ->orWhere('usuario', $email);
                    })->where('estado', 'activo')->first();
                    break;
                    
                case 'medico':
                    // Buscar por email primero
                    $user = Medicos::where('email', $email)->first();
                    
                    // Si no encuentra por email, buscar por usuario
                    if (!$user) {
                        $user = Medicos::where('usuario', $email)->first();
                    }
                    
                    // Si aún no encuentra, buscar por cualquier campo que contenga el email
                    if (!$user) {
                        $user = Medicos::where(function($query) use ($email) {
                            $query->where('email', 'like', '%' . $email . '%')
                                  ->orWhere('usuario', 'like', '%' . $email . '%')
                                  ->orWhere('nombre', 'like', '%' . $email . '%');
                        })->first();
                    }
                    
                    // Verificar que esté activo
                    if ($user && $user->estado_auth !== 'activo') {
                        Log::warning('⚠️ Médico encontrado pero inactivo', [
                            'email' => $email,
                            'usuario' => $user->usuario,
                            'estado_auth' => $user->estado_auth,
                            'id' => $user->id
                        ]);
                        $user = null;
                    }
                    break;
                    
                case 'paciente':
                    $user = Pacientes::where(function($query) use ($email) {
                        $query->where('email', $email)
                              ->orWhere('usuario', $email);
                    })->where('estado_auth', 'activo')->first();
                    break;
            }

            if (!$user) {
                Log::warning('❌ Usuario no encontrado', [
                    'email' => $email,
                    'tipo_usuario' => $tipo
                ]);
                
                // Para debugging, mostrar qué usuarios existen
                if ($tipo === 'medico') {
                    $medicosExistentes = Medicos::select('id', 'nombre', 'apellido', 'email', 'usuario', 'estado_auth')->get();
                    Log::info('📋 Médicos existentes en BD:', $medicosExistentes->toArray());
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado o inactivo'
                ], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                Log::warning('🔒 Contraseña incorrecta', [
                    'email' => $email,
                    'tipo_usuario' => $tipo,
                    'user_id' => $user->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Contraseña incorrecta'
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('✅ Login exitoso', [
                'user_id' => $user->id,
                'tipo_usuario' => $tipo,
                'email' => $user->email,
                'nombre' => $user->nombre . ' ' . $user->apellido
            ]);

            // Preparar datos del usuario para el frontend
            $userData = [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'apellido' => $user->apellido,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'usuario' => $user->usuario,
                'role' => $tipo // Agregar 'role' para compatibilidad con frontend
            ];

            // Agregar datos específicos según el tipo
            if ($tipo === 'medico') {
                $userData['especialidad_id'] = $user->especialidad_id ?? null;
                $userData['numero_tarjeta'] = $user->numero_tarjeta ?? null;
            }

            if ($tipo === 'paciente') {
                $userData['eps_id'] = $user->eps_id ?? null;
                $userData['cedula'] = $user->cedula ?? null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Login correcto',
                'user' => $userData,
                'tipo_usuario' => $tipo,
                'token' => $token,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Error de validación', [
                'errors' => $e->errors(),
                'email' => $request->email ?? 'N/A',
                'tipo_usuario' => $request->tipo_usuario ?? 'N/A'
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('❌ Error inesperado en login', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $request->email ?? 'N/A',
                'tipo_usuario' => $request->tipo_usuario ?? 'N/A'
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Método para debugging - ver médicos existentes
    public function debugMedicos()
    {
        try {
            $medicos = Medicos::select('id', 'nombre', 'apellido', 'email', 'usuario', 'estado_auth', 'estado')->get();
            
            Log::info('🔍 Debug médicos - Total encontrados:', ['count' => $medicos->count()]);
            
            return response()->json([
                'success' => true,
                'total' => $medicos->count(),
                'medicos' => $medicos
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error en debug médicos', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener médicos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para debugging - ver administradores existentes
    public function debugAdmins()
    {
        try {
            $admins = Administrador::select('id', 'nombre', 'apellido', 'email', 'usuario', 'estado')->get();
            
            Log::info('🔍 Debug administradores - Total encontrados:', ['count' => $admins->count()]);
            
            return response()->json([
                'success' => true,
                'total' => $admins->count(),
                'administradores' => $admins
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error en debug administradores', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener administradores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Registro solo para pacientes (público)
    public function registerPaciente(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'cedula' => 'required|string|max:20|unique:pacientes,cedula',
                'fecha_nacimiento' => 'required|date',
                'telefono' => 'nullable|string|max:20',
                'email' => 'required|email|unique:pacientes,email',
                'direccion' => 'nullable|string',
                'eps_id' => 'nullable|exists:eps,id',
                'tipo_afiliacion' => 'required|in:Cotizante,Beneficiario',
                'numero_afiliacion' => 'nullable|string|max:50',
                'grupo_sanguineo' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'alergias' => 'nullable|string',
                'medicamentos_actuales' => 'nullable|string',
                'contacto_emergencia_nombre' => 'nullable|string|max:150',
                'contacto_emergencia_telefono' => 'nullable|string|max:20',
                'password' => 'required|string|min:6',
            ]);

            // Generar usuario único basado en email
            $usuario = $request->email;

            $paciente = Pacientes::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'direccion' => $request->direccion,
                'eps_id' => $request->eps_id,
                'tipo_afiliacion' => $request->tipo_afiliacion,
                'numero_afiliacion' => $request->numero_afiliacion,
                'grupo_sanguineo' => $request->grupo_sanguineo,
                'alergias' => $request->alergias,
                'medicamentos_actuales' => $request->medicamentos_actuales,
                'contacto_emergencia_nombre' => $request->contacto_emergencia_nombre,
                'contacto_emergencia_telefono' => $request->contacto_emergencia_telefono,
                'estado' => 'activo',
                'usuario' => $usuario,
                'password' => bcrypt($request->password),
                'estado_auth' => 'activo',
            ]);

            $token = $paciente->createToken('auth_token')->plainTextToken;

            Log::info('✅ Paciente registrado exitosamente', [
                'paciente_id' => $paciente->id,
                'email' => $paciente->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Paciente registrado correctamente',
                'user' => $paciente,
                'tipo_usuario' => 'paciente',
                'token' => $token,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('❌ Error en registro de paciente', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Crear médico (solo administradores)
    public function crearMedico(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'cedula' => 'required|string|max:20|unique:medicos,cedula',
                'especialidad_id' => 'required|exists:especialidades,id',
                'telefono' => 'nullable|string|max:20',
                'email' => 'required|email|unique:medicos,email',
                'direccion' => 'nullable|string',
                'experiencia_anos' => 'required|integer|min:0',
                'consultorio_id' => 'nullable|exists:consultorios,id',
                'horario_inicio' => 'nullable|date_format:H:i',
                'horario_fin' => 'nullable|date_format:H:i',
                'dias_trabajo' => 'nullable|string',
                'tarifa_consulta' => 'nullable|numeric|min:0',
                'usuario' => 'required|string|max:50|unique:medicos,usuario',
                'password' => 'required|string|min:6',
            ]);

            $medico = Medicos::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'especialidad_id' => $request->especialidad_id,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'direccion' => $request->direccion,
                'experiencia_anos' => $request->experiencia_anos,
                'consultorio_id' => $request->consultorio_id,
                'horario_inicio' => $request->horario_inicio,
                'horario_fin' => $request->horario_fin,
                'dias_trabajo' => $request->dias_trabajo,
                'tarifa_consulta' => $request->tarifa_consulta,
                'estado' => 'activo',
                'usuario' => $request->usuario,
                'password' => bcrypt($request->password),
                'estado_auth' => 'activo',
            ]);

            Log::info('✅ Médico creado exitosamente', [
                'medico_id' => $medico->id,
                'email' => $medico->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Médico creado correctamente',
                'medico' => $medico,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('❌ Error en creación de médico', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Crear administrador (solo super admin)
    public function crearAdministrador(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'email' => 'required|email|unique:administradores,email',
                'telefono' => 'nullable|string|max:20',
                'usuario' => 'required|string|max:50|unique:administradores,usuario',
                'password' => 'required|string|min:6',
            ]);

            $admin = Administrador::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'usuario' => $request->usuario,
                'password' => bcrypt($request->password),
                'estado' => 'activo',
            ]);

            Log::info('✅ Administrador creado exitosamente', [
                'admin_id' => $admin->id,
                'email' => $admin->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Administrador creado correctamente',
                'administrador' => $admin,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('❌ Error en creación de administrador', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Obtener datos del usuario actual
    public function me(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }
            
            // Determinar el tipo de usuario basado en la tabla
            $tipo_usuario = 'desconocido';
            if ($user instanceof Administrador) {
                $tipo_usuario = 'administrador';
            } elseif ($user instanceof Medicos) {
                $tipo_usuario = 'medico';
            } elseif ($user instanceof Pacientes) {
                $tipo_usuario = 'paciente';
            }

            return response()->json([
                'success' => true,
                'user' => $user,
                'tipo_usuario' => $tipo_usuario,
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en me()', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user) {
                $user->currentAccessToken()->delete();
                
                Log::info('✅ Logout exitoso', [
                    'user_id' => $user->id
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sesión cerrada correctamente',
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en logout', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // Método para verificar el estado del servidor
    public function health()
    {
        return response()->json([
            'success' => true,
            'message' => 'Servidor funcionando correctamente',
            'timestamp' => now(),
        ]);
    }
}
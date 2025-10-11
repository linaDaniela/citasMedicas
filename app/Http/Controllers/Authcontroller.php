<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Administrador;
use App\Models\Medico;
use App\Models\Paciente;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'tipo' => 'required|in:admin,medico,paciente'
        ]);

        $user = null;
        $tipo = $request->tipo;

        // Buscar usuario según el tipo
        switch ($tipo) {
            case 'admin':
                $user = DB::table('administradores')
                    ->where('email', $request->email)
                    ->where('activo', 1)
                    ->first();
                break;
            case 'medico':
                $user = DB::table('medicos')
                    ->where('email', $request->email)
                    ->first();
                break;
            case 'paciente':
                $user = DB::table('pacientes')
                    ->where('email', $request->email)
                    ->first();
                break;
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Crear token simple (no usar Sanctum por ahora)
        $token = $tipo . '_token_' . $user->id;

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->nombre,
                    'apellido' => $user->apellido,
                    'email' => $user->email,
                    'telefono' => $user->telefono ?? null,
                    'tipo' => $tipo
                ],
                'token' => $token,
                'tipo' => $tipo
            ]
        ]);
    }

    public function registerPaciente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:pacientes,email',
            'password' => 'required|string|min:6',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        try {
            $pacienteId = DB::table('pacientes')->insertGetId([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $paciente = DB::table('pacientes')->where('id', $pacienteId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Registro exitoso',
                'data' => [
                    'user' => [
                        'id' => $paciente->id,
                        'nombre' => $paciente->nombre,
                        'apellido' => $paciente->apellido,
                        'email' => $paciente->email,
                        'telefono' => $paciente->telefono,
                        'tipo' => 'paciente'
                    ],
                    'token' => 'paciente_token_' . $paciente->id,
                    'tipo' => 'paciente'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar paciente: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================
    // 🔹 FUNCIÓN PARA ACTUALIZAR PERFIL
    // ==========================

    public function updateProfile(Request $request)
    {
        try {
            Log::info('AuthController@updateProfile - Datos recibidos: ', $request->all());

            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'telefono' => 'nullable|string',
                'direccion' => 'nullable|string',
                'user_id' => 'required|integer',
                'user_type' => 'required|string|in:admin,medico,paciente'
            ]);

            $userId = $request->user_id;
            $userType = $request->user_type;

            Log::info('AuthController@updateProfile - Usuario ID: ' . $userId . ', Tipo: ' . $userType);

            // Determinar en qué tabla actualizar según el tipo de usuario
            $tableName = '';
            switch ($userType) {
                case 'admin':
                    $tableName = 'administradores';
                    break;
                case 'medico':
                    $tableName = 'medicos';
                    break;
                case 'paciente':
                default:
                    $tableName = 'pacientes';
                    break;
            }

            Log::info('AuthController@updateProfile - Actualizando tabla: ' . $tableName);

            // Verificar que el usuario existe
            $userExists = DB::table($tableName)->where('id', $userId)->exists();
            if (!$userExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Actualizar los datos del usuario
            $updateData = [
                'nombre' => $request->name,
                'email' => $request->email,
                'updated_at' => now()
            ];

            // Agregar campos específicos según el tipo de usuario
            if ($request->has('telefono')) {
                $updateData['telefono'] = $request->telefono;
            }
            if ($request->has('direccion')) {
                $updateData['direccion'] = $request->direccion;
            }

            DB::table($tableName)->where('id', $userId)->update($updateData);

            Log::info('AuthController@updateProfile - Perfil actualizado exitosamente');

            // Obtener los datos actualizados del usuario
            $user = DB::table($tableName)->where('id', $userId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            Log::error('AuthController@updateProfile - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================
    // 🔹 FUNCIÓN PARA CAMBIAR CONTRASEÑA
    // ==========================

    public function changePassword(Request $request)
    {
        try {
            Log::info('AuthController@changePassword - Datos recibidos: ', $request->all());

            $request->validate([
                'email' => 'required|email',
                'currentPassword' => 'required|string',
                'newPassword' => 'required|string|min:6',
                'user_id' => 'required|integer',
                'user_type' => 'required|string|in:admin,medico,paciente'
            ]);

            $userId = $request->user_id;
            $userType = $request->user_type;
            $email = $request->email;

            Log::info('AuthController@changePassword - Usuario ID: ' . $userId . ', Tipo: ' . $userType . ', Email: ' . $email);

            // Determinar en qué tabla buscar según el tipo de usuario
            $tableName = '';
            switch ($userType) {
                case 'admin':
                    $tableName = 'administradores';
                    break;
                case 'medico':
                    $tableName = 'medicos';
                    break;
                case 'paciente':
                default:
                    $tableName = 'pacientes';
                    break;
            }

            Log::info('AuthController@changePassword - Buscando en tabla: ' . $tableName);

            // Buscar el usuario por ID y email
            $user = DB::table($tableName)
                ->where('id', $userId)
                ->where('email', $email)
                ->where('activo', 1)
                ->first();

            if (!$user) {
                Log::warning('AuthController@changePassword - Usuario no encontrado');
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            Log::info('AuthController@changePassword - Usuario encontrado: ' . $user->nombre);

            // Verificar que la contraseña actual sea correcta
            if (!Hash::check($request->currentPassword, $user->password)) {
                Log::warning('AuthController@changePassword - Contraseña actual incorrecta');
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 401);
            }

            Log::info('AuthController@changePassword - Contraseña actual verificada correctamente');

            // Actualizar la contraseña
            $hashedNewPassword = Hash::make($request->newPassword);
            
            DB::table($tableName)
                ->where('id', $userId)
                ->update([
                    'password' => $hashedNewPassword,
                    'updated_at' => now()
                ]);

            Log::info('AuthController@changePassword - Contraseña actualizada exitosamente');

            return response()->json([
                'success' => true,
                'message' => 'Contraseña cambiada exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('AuthController@changePassword - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar contraseña: ' . $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdministradorController extends Controller
{
    public function index()
    {
        try {
            Log::info('AdministradorController@index - Iniciando consulta de administradores');
            
            $administradores = DB::table('administradores')
                ->select('*')
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('AdministradorController@index - Administradores obtenidos: ' . $administradores->count());

            return response()->json([
                'success' => true,
                'data' => $administradores
            ]);
        } catch (\Exception $e) {
            Log::error('AdministradorController@index - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener administradores: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('AdministradorController@store - Datos recibidos: ', $request->all());

            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|email|unique:administradores,email',
                'password' => 'required|string|min:6',
                'telefono' => 'required|string|max:20'
            ]);

            $administradorId = DB::table('administradores')->insertGetId([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('AdministradorController@store - Administrador creado con ID: ' . $administradorId);

            $administrador = DB::table('administradores')->where('id', $administradorId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Administrador creado exitosamente',
                'data' => $administrador
            ], 201);

        } catch (\Exception $e) {
            Log::error('AdministradorController@store - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear administrador: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            Log::info('AdministradorController@show - Buscando administrador con ID: ' . $id);

            $administrador = DB::table('administradores')->where('id', $id)->first();

            if (!$administrador) {
                Log::warning('AdministradorController@show - Administrador no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Administrador no encontrado'
                ], 404);
            }

            Log::info('AdministradorController@show - Administrador encontrado: ' . $administrador->id);

            return response()->json([
                'success' => true,
                'data' => $administrador
            ]);

        } catch (\Exception $e) {
            Log::error('AdministradorController@show - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('AdministradorController@update - Actualizando administrador ID: ' . $id);
            Log::info('AdministradorController@update - Datos recibidos: ', $request->all());

            $administrador = DB::table('administradores')->where('id', $id)->first();
            if (!$administrador) {
                Log::warning('AdministradorController@update - Administrador no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Administrador no encontrado'
                ], 404);
            }

            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|email|unique:administradores,email,' . $id,
                'telefono' => 'required|string|max:20',
                'activo' => 'boolean'
            ]);

            $updateData = [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'activo' => $request->activo ?? $administrador->activo,
                'updated_at' => now()
            ];

            // Solo actualizar password si se proporciona
            if ($request->has('password') && !empty($request->password)) {
                $updateData['password'] = Hash::make($request->password);
            }

            DB::table('administradores')->where('id', $id)->update($updateData);

            Log::info('AdministradorController@update - Administrador actualizado exitosamente');

            $administradorActualizado = DB::table('administradores')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Administrador actualizado exitosamente',
                'data' => $administradorActualizado
            ]);

        } catch (\Exception $e) {
            Log::error('AdministradorController@update - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar administrador: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('AdministradorController@destroy - Eliminando administrador con ID: ' . $id);

            $administrador = DB::table('administradores')->where('id', $id)->first();
            if (!$administrador) {
                Log::warning('AdministradorController@destroy - Administrador no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Administrador no encontrado'
                ], 404);
            }

            // No permitir eliminar el último administrador
            $totalAdmins = DB::table('administradores')->count();
            if ($totalAdmins <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el último administrador del sistema'
                ], 400);
            }

            DB::table('administradores')->where('id', $id)->delete();

            Log::info('AdministradorController@destroy - Administrador eliminado exitosamente');

            return response()->json([
                'success' => true,
                'message' => 'Administrador eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('AdministradorController@destroy - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar administrador: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getEstadisticas()
    {
        try {
            Log::info('AdministradorController@getEstadisticas - Generando estadísticas');

            // Estadísticas de administradores
            $totalAdmins = DB::table('administradores')->count();
            $adminsActivos = DB::table('administradores')->where('activo', 1)->count();

            // Estadísticas de médicos
            $totalMedicos = DB::table('medicos')->count();

            // Estadísticas de pacientes
            $totalPacientes = DB::table('pacientes')->count();

            // Estadísticas de especialidades
            $totalEspecialidades = DB::table('especialidades')->count();

            // Estadísticas de citas
            $totalCitas = DB::table('citas')->count();
            $citasHoy = DB::table('citas')->where('fecha', now()->format('Y-m-d'))->count();
            $citasProgramadas = DB::table('citas')->where('estado', 'programada')->count();
            $citasConfirmadas = DB::table('citas')->where('estado', 'confirmada')->count();
            $citasCompletadas = DB::table('citas')->where('estado', 'completada')->count();
            $citasCanceladas = DB::table('citas')->where('estado', 'cancelada')->count();

            $estadisticas = [
                'administradores' => [
                    'total' => $totalAdmins,
                    'activos' => $adminsActivos
                ],
                'medicos' => [
                    'total' => $totalMedicos,
                    'activos' => $totalMedicos // Todos están activos por defecto
                ],
                'pacientes' => [
                    'total' => $totalPacientes,
                    'activos' => $totalPacientes // Todos están activos por defecto
                ],
                'especialidades' => [
                    'total' => $totalEspecialidades
                ],
                'citas' => [
                    'total' => $totalCitas,
                    'hoy' => $citasHoy,
                    'programadas' => $citasProgramadas,
                    'confirmadas' => $citasConfirmadas,
                    'completadas' => $citasCompletadas,
                    'canceladas' => $citasCanceladas
                ]
            ];

            Log::info('AdministradorController@getEstadisticas - Estadísticas generadas:', $estadisticas);

            return response()->json([
                'success' => true,
                'data' => $estadisticas
            ]);

        } catch (\Exception $e) {
            Log::error('AdministradorController@getEstadisticas - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspecialidadController extends Controller
{
    public function index()
    {
        try {
            // Obtener todas las especialidades sin filtrar por activo
            $especialidades = DB::table('especialidades')->get();
            
            return response()->json([
                'success' => true,
                'data' => $especialidades
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener especialidades: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255'
            ]);

            // Crear especialidad sin campo descripcion
            $especialidadId = DB::table('especialidades')->insertGetId([
                'nombre' => $request->nombre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $especialidad = DB::table('especialidades')->where('id', $especialidadId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Especialidad creada exitosamente',
                'data' => $especialidad
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $especialidad = DB::table('especialidades')->where('id', $id)->first();
            
            if (!$especialidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Especialidad no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $especialidad
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $especialidad = DB::table('especialidades')->where('id', $id)->first();
            
            if (!$especialidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Especialidad no encontrada'
                ], 404);
            }

            $request->validate([
                'nombre' => 'required|string|max:255'
            ]);

            DB::table('especialidades')->where('id', $id)->update([
                'nombre' => $request->nombre,
                'updated_at' => now(),
            ]);

            $especialidadActualizada = DB::table('especialidades')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Especialidad actualizada exitosamente',
                'data' => $especialidadActualizada
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $especialidad = DB::table('especialidades')->where('id', $id)->first();
            
            if (!$especialidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Especialidad no encontrada'
                ], 404);
            }

            // Eliminar especialidad completamente
            DB::table('especialidades')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Especialidad eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar especialidad: ' . $e->getMessage()
            ], 500);
        }
    }
}

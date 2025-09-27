<?php

namespace App\Http\Controllers;

use App\Models\Consultorios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ConsultoriosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Versión simplificada sin relaciones para evitar errores
            $consultorios = Consultorios::select('id', 'nombre', 'numero', 'piso', 'edificio', 'estado')->get();
            return response()->json($consultorios);
        } catch (\Exception $e) {
            Log::error('Error en ConsultoriosController::index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error interno del servidor al obtener consultorios'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100',
                'numero' => 'required|string|max:20|unique:consultorios,numero',
                'piso' => 'nullable|string|max:10',
                'edificio' => 'nullable|string|max:50',
                'direccion' => 'nullable|string',
                'telefono' => 'nullable|string|max:20',
                'capacidad_pacientes' => 'nullable|integer|min:1',
                'equipos_medicos' => 'nullable|string',
                'estado' => 'nullable|in:disponible,ocupado,mantenimiento',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $consultorio = Consultorios::create([
                'nombre' => $request->nombre,
                'numero' => $request->numero,
                'piso' => $request->piso,
                'edificio' => $request->edificio,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'capacidad_pacientes' => $request->capacidad_pacientes,
                'equipos_medicos' => $request->equipos_medicos,
                'estado' => $request->estado ?? 'disponible',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Consultorio creado exitosamente',
                'consultorio' => $consultorio
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error en ConsultoriosController::store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error interno del servidor al crear consultorio'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $consultorio = Consultorios::find($id);

            if (!$consultorio) {
                return response()->json(['message' => 'Consultorio no encontrado'], 404);
            }

            return response()->json($consultorio);
        } catch (\Exception $e) {
            Log::error('Error en ConsultoriosController::show', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error interno del servidor al obtener consultorio'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $consultorio = Consultorios::find($id);

            if (!$consultorio) {
                return response()->json(['message' => 'Consultorio no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nombre' => 'string|max:100',
                'numero' => 'string|max:20|unique:consultorios,numero,' . $id,
                'piso' => 'nullable|string|max:10',
                'edificio' => 'nullable|string|max:50',
                'direccion' => 'nullable|string',
                'telefono' => 'nullable|string|max:20',
                'capacidad_pacientes' => 'nullable|integer|min:1',
                'equipos_medicos' => 'nullable|string',
                'estado' => 'in:disponible,ocupado,mantenimiento',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $consultorio->update([
                'nombre' => $request->nombre ?? $consultorio->nombre,
                'numero' => $request->numero ?? $consultorio->numero,
                'piso' => $request->piso ?? $consultorio->piso,
                'edificio' => $request->edificio ?? $consultorio->edificio,
                'direccion' => $request->direccion ?? $consultorio->direccion,
                'telefono' => $request->telefono ?? $consultorio->telefono,
                'capacidad_pacientes' => $request->capacidad_pacientes ?? $consultorio->capacidad_pacientes,
                'equipos_medicos' => $request->equipos_medicos ?? $consultorio->equipos_medicos,
                'estado' => $request->estado ?? $consultorio->estado,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Consultorio actualizado exitosamente',
                'consultorio' => $consultorio
            ]);

        } catch (\Exception $e) {
            Log::error('Error en ConsultoriosController::update', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error interno del servidor al actualizar consultorio'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $consultorio = Consultorios::find($id);

            if (!$consultorio) {
                return response()->json(['message' => 'Consultorio no encontrado'], 404);
            }

            $consultorio->delete();

            return response()->json([
                'success' => true,
                'message' => 'Consultorio eliminado exitosamente'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error en ConsultoriosController::destroy', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error interno del servidor al eliminar consultorio'], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Consultorios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultoriosController extends Controller
{
    public function index()
    {
        $consultorios = Consultorios::with(['medicos', 'citas'])->get();
        return response()->json($consultorios);
    }

    public function store(Request $request)
    {
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
            return response()->json($validator->errors(), 422);
        }

        $consultorio = Consultorios::create($validator->validated());
        $consultorio->refresh();

        return response()->json($consultorio, 201);
    }

    public function show(string $id)
    {
        $consultorio = Consultorios::with(['medicos', 'citas'])->find($id);

        if (!$consultorio) {
            return response()->json(['message' => 'Consultorio no encontrado'], 404);
        }

        return response()->json($consultorio);
    }

    public function update(Request $request, string $id)
    {
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
            return response()->json($validator->errors(), 422);
        }

        $consultorio->update($validator->validated());
        $consultorio->refresh();

        return response()->json($consultorio);
    }

    public function destroy(string $id)
    {
        $consultorio = Consultorios::find($id);

        if (!$consultorio) {
            return response()->json(['message' => 'Consultorio no encontrado'], 404);
        }

        $consultorio->delete();

        return response()->json(['message' => 'Consultorio eliminado correctamente']);
    }
}
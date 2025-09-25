<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacientesController extends Controller
{
    public function index()
    {
        $pacientes = Pacientes::with(['citas', 'historiales'])->get();
        return response()->json($pacientes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string',
            'apellido'         => 'required|string',
            'numero_documento' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'email'            => 'nullable|email',
            'telefono'         => 'nullable|string',
            'genero'           => 'required|string|in:M,F'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $paciente = Pacientes::create($validator->validated());
        $paciente->refresh(); 

        return response()->json($paciente, 200);
    }

    public function show(string $id)
    {
        $paciente = Pacientes::with(['citas', 'historiales'])->find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        return response()->json($paciente);
    }

    public function update(Request $request, string $id)
    {
        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'           => 'string',
            'apellido'         => 'string',
            'numero_documento' => 'string',
            'fecha_nacimiento' => 'date',
            'email'            => 'nullable|email',
            'telefono'         => 'nullable|string',
            'genero'           => 'string|in:M,F'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $paciente->update($validator->validated());
        $paciente->refresh(); 

        return response()->json($paciente);
    }

    public function destroy(string $id)
    {
        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}

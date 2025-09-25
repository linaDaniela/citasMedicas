<?php

namespace App\Http\Controllers;

use App\Models\Medicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicosController extends Controller
{
    public function index()
    {
        $medicos = Medicos::with('especialidad')->get();
        return response()->json($medicos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'          => 'required|string',
            'apellido'        => 'required|string',
            'numero_documento'=> 'required|string',
            'email'           => 'nullable|email',
            'telefono'        => 'nullable|string',
            'especialidad_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $medico = Medicos::create($validator->validated());
        $medico->refresh();

        return response()->json($medico, 200);
    }

    public function show(string $id)
    {
        $medico = Medicos::with('especialidad')->find($id);

        if (!$medico) {
            return response()->json(['message' => 'Médico no encontrado'], 404);
        }

        return response()->json($medico);
    }

    public function update(Request $request, string $id)
    {
        $medico = Medicos::find($id);

        if (!$medico) {
            return response()->json(['message' => 'Médico no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'          => 'string',
            'apellido'        => 'string',
            'numero_documento'=> 'string',
            'email'           => 'nullable|email',
            'telefono'        => 'nullable|string',
            'especialidad_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $medico->update($validator->validated());
        $medico->refresh(); 

        return response()->json($medico);
    }

    public function destroy(string $id)
    {
        $medico = Medicos::find($id);

        if (!$medico) {
            return response()->json(['message' => 'Médico no encontrado'], 404);
        }

        $medico->delete();

        return response()->json(['message' => 'Médico eliminado correctamente']);
    }
}

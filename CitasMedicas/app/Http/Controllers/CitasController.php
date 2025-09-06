<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Citas::all();
        return response()->json($citas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id'     => 'required|integer',
            'medico_id'       => 'required|integer',
            'especialidad_id' => 'required|integer',
            'fecha_hora'      => 'required|date',
            'estado'          => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cita = Citas::create($validator->validated());
        $cita->refresh();

        return response()->json($cita, 200);
    }

    public function show(string $id)
    {
        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita);
    }

    public function update(Request $request, string $id)
    {
        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'paciente_id'     => 'integer',
            'medico_id'       => 'integer',
            'especialidad_id' => 'integer',
            'fecha_hora'      => 'date',
            'estado'          => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cita->update($validator->validated());
        $cita->refresh();

        return response()->json($cita);
    }

    public function destroy(string $id)
    {
        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['message' => 'Cita eliminada correctamente']);
    }
}

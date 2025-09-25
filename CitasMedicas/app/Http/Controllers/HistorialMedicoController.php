<?php

namespace App\Http\Controllers;

use App\Models\HistorialMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialMedicoController extends Controller
{
    public function index()
    {
        $historial = HistorialMedico::with(['paciente', 'medico', 'cita'])->get();
        return response()->json($historial);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'cita_id' => 'nullable|exists:citas,id',
            'motivo_consulta' => 'nullable|string',
            'sintomas' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'medicamentos_recetados' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'archivos_adjuntos' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $historial = HistorialMedico::create($validator->validated());
        $historial->load(['paciente', 'medico', 'cita']);

        return response()->json($historial, 201);
    }

    public function show(string $id)
    {
        $historial = HistorialMedico::with(['paciente', 'medico', 'cita'])->find($id);

        if (!$historial) {
            return response()->json(['message' => 'Registro de historial no encontrado'], 404);
        }

        return response()->json($historial);
    }

    public function update(Request $request, string $id)
    {
        $historial = HistorialMedico::find($id);

        if (!$historial) {
            return response()->json(['message' => 'Registro de historial no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'motivo_consulta' => 'nullable|string',
            'sintomas' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'medicamentos_recetados' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'archivos_adjuntos' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $historial->update($validator->validated());
        $historial->load(['paciente', 'medico', 'cita']);

        return response()->json($historial);
    }

    public function destroy(string $id)
    {
        $historial = HistorialMedico::find($id);

        if (!$historial) {
            return response()->json(['message' => 'Registro de historial no encontrado'], 404);
        }

        $historial->delete();

        return response()->json(['message' => 'Registro de historial eliminado correctamente']);
    }

    public function getByPaciente(string $pacienteId)
    {
        $historial = HistorialMedico::with(['medico', 'cita'])
            ->where('paciente_id', $pacienteId)
            ->orderBy('fecha_consulta', 'desc')
            ->get();

        return response()->json($historial);
    }
}
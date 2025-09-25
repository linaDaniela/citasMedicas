<?php

namespace App\Http\Controllers;

use App\Models\RecetasMedicas;
use App\Models\DetalleRecetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RecetasMedicasController extends Controller
{
    public function index()
    {
        $recetas = RecetasMedicas::with(['cita', 'paciente', 'medico', 'detalleRecetas.medicamento'])->get();
        return response()->json($recetas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cita_id' => 'required|exists:citas,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'instrucciones' => 'nullable|string',
            'estado' => 'nullable|in:pendiente,dispensada,cancelada',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamento_id' => 'required|exists:medicamentos,id',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
            'medicamentos.*.dosis' => 'nullable|string|max:100',
            'medicamentos.*.frecuencia' => 'nullable|string|max:100',
            'medicamentos.*.duracion' => 'nullable|string|max:50',
            'medicamentos.*.observaciones' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        try {
            $receta = RecetasMedicas::create([
                'cita_id' => $request->cita_id,
                'paciente_id' => $request->paciente_id,
                'medico_id' => $request->medico_id,
                'instrucciones' => $request->instrucciones,
                'estado' => $request->estado ?? 'pendiente',
            ]);

            foreach ($request->medicamentos as $medicamento) {
                DetalleRecetas::create([
                    'receta_id' => $receta->id,
                    'medicamento_id' => $medicamento['medicamento_id'],
                    'cantidad' => $medicamento['cantidad'],
                    'dosis' => $medicamento['dosis'] ?? null,
                    'frecuencia' => $medicamento['frecuencia'] ?? null,
                    'duracion' => $medicamento['duracion'] ?? null,
                    'observaciones' => $medicamento['observaciones'] ?? null,
                ]);
            }

            DB::commit();
            $receta->load(['cita', 'paciente', 'medico', 'detalleRecetas.medicamento']);

            return response()->json($receta, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al crear la receta: ' . $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $receta = RecetasMedicas::with(['cita', 'paciente', 'medico', 'detalleRecetas.medicamento'])->find($id);

        if (!$receta) {
            return response()->json(['message' => 'Receta no encontrada'], 404);
        }

        return response()->json($receta);
    }

    public function update(Request $request, string $id)
    {
        $receta = RecetasMedicas::find($id);

        if (!$receta) {
            return response()->json(['message' => 'Receta no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'instrucciones' => 'nullable|string',
            'estado' => 'in:pendiente,dispensada,cancelada',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $receta->update($validator->validated());
        $receta->load(['cita', 'paciente', 'medico', 'detalleRecetas.medicamento']);

        return response()->json($receta);
    }

    public function destroy(string $id)
    {
        $receta = RecetasMedicas::find($id);

        if (!$receta) {
            return response()->json(['message' => 'Receta no encontrada'], 404);
        }

        $receta->delete();

        return response()->json(['message' => 'Receta eliminada correctamente']);
    }
}
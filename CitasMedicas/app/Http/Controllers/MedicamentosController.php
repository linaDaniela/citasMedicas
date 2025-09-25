<?php

namespace App\Http\Controllers;

use App\Models\Medicamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicamentosController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamentos::with('detalleRecetas')->get();
        return response()->json($medicamentos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:200',
            'principio_activo' => 'nullable|string|max:200',
            'laboratorio' => 'nullable|string|max:150',
            'presentacion' => 'nullable|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'indicaciones' => 'nullable|string',
            'contraindicaciones' => 'nullable|string',
            'efectos_secundarios' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'estado' => 'nullable|in:disponible,agotado,descontinuado',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $medicamento = Medicamentos::create($validator->validated());
        $medicamento->refresh();

        return response()->json($medicamento, 201);
    }

    public function show(string $id)
    {
        $medicamento = Medicamentos::with('detalleRecetas')->find($id);

        if (!$medicamento) {
            return response()->json(['message' => 'Medicamento no encontrado'], 404);
        }

        return response()->json($medicamento);
    }

    public function update(Request $request, string $id)
    {
        $medicamento = Medicamentos::find($id);

        if (!$medicamento) {
            return response()->json(['message' => 'Medicamento no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:200',
            'principio_activo' => 'nullable|string|max:200',
            'laboratorio' => 'nullable|string|max:150',
            'presentacion' => 'nullable|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'indicaciones' => 'nullable|string',
            'contraindicaciones' => 'nullable|string',
            'efectos_secundarios' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'estado' => 'in:disponible,agotado,descontinuado',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $medicamento->update($validator->validated());
        $medicamento->refresh();

        return response()->json($medicamento);
    }

    public function destroy(string $id)
    {
        $medicamento = Medicamentos::find($id);

        if (!$medicamento) {
            return response()->json(['message' => 'Medicamento no encontrado'], 404);
        }

        $medicamento->delete();

        return response()->json(['message' => 'Medicamento eliminado correctamente']);
    }
}
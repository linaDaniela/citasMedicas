<?php

namespace App\Http\Controllers;

use App\Models\Eps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EpsController extends Controller
{
    public function index()
    {
        $eps = Eps::all();
        return response()->json($eps);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:150',
            'nit' => 'required|string|max:20|unique:eps,nit',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'sitio_web' => 'nullable|url|max:200',
            'representante_legal' => 'nullable|string|max:150',
            'telefono_representante' => 'nullable|string|max:20',
            'email_representante' => 'nullable|email|max:150',
            'tipo_eps' => 'required|in:Contributiva,Subsidiada,Mixta',
            'estado' => 'nullable|in:Activa,Inactiva,Suspendida,En Proceso',
            'fecha_afiliacion' => 'nullable|date',
            'calificacion' => 'nullable|numeric|min:0|max:5',
            'observaciones' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $eps = Eps::create($validator->validated());
        $eps->refresh(); 

        return response()->json($eps, 201);
    }

    public function show(string $id)
    {
        $eps = Eps::find($id);

        if (!$eps) {
            return response()->json(['message' => 'EPS no encontrada'], 404);
        }

        return response()->json($eps);
    }

    public function update(Request $request, string $id)
    {
        $eps = Eps::find($id);

        if (!$eps) {
            return response()->json(['message' => 'EPS no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:150',
            'nit' => 'string|max:20|unique:eps,nit,' . $id,
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'sitio_web' => 'nullable|url|max:200',
            'representante_legal' => 'nullable|string|max:150',
            'telefono_representante' => 'nullable|string|max:20',
            'email_representante' => 'nullable|email|max:150',
            'tipo_eps' => 'in:Contributiva,Subsidiada,Mixta',
            'estado' => 'in:Activa,Inactiva,Suspendida,En Proceso',
            'fecha_afiliacion' => 'nullable|date',
            'calificacion' => 'nullable|numeric|min:0|max:5',
            'observaciones' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $eps->update($validator->validated());
        $eps->refresh();

        return response()->json($eps);
    }

    public function destroy(string $id)
    {
        $eps = Eps::find($id);

        if (!$eps) {
            return response()->json(['message' => 'EPS no encontrada'], 404);
        }

        $eps->delete();

        return response()->json(['message' => 'EPS eliminada correctamente']);
    }
}

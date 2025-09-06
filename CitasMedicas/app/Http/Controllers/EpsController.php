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
            'nombre'    => 'required|string',
            'direccion' => 'required|string',
            'telefono'  => 'required|string',
            'email'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $eps = Eps::create($validator->validated());
        $eps->refresh(); 

        return response()->json($eps, 200);
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
            'nombre'    => 'string',
            'direccion' => 'string',
            'telefono'  => 'string',
            'email'     => 'string',
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

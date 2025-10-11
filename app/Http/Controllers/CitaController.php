<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function index()
    {
        try {
            Log::info('CitaController@index - Iniciando consulta de citas');
            
            $citas = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'pacientes.telefono as paciente_telefono',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->orderBy('citas.fecha', 'desc')
                ->orderBy('citas.hora', 'desc')
                ->get();

            Log::info('CitaController@index - Citas obtenidas: ' . $citas->count());

            return response()->json([
                'success' => true,
                'data' => $citas
            ]);
        } catch (\Exception $e) {
            Log::error('CitaController@index - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener citas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('CitaController@store - Datos recibidos: ', $request->all());

            $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'medico_id' => 'required|exists:medicos,id',
                'fecha' => 'required|date_format:Y-m-d',
                'hora' => 'required|date_format:H:i:s',
                'motivo' => 'required|string',
                'estado' => 'nullable|in:programada,confirmada,completada,cancelada'
            ]);

            Log::info('CitaController@store - Creando cita');

            $citaId = DB::table('citas')->insertGetId([
                'paciente_id' => $request->paciente_id,
                'medico_id' => $request->medico_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'estado' => $request->estado ?? 'programada',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('CitaController@store - Cita creada con ID: ' . $citaId);

            // Obtener la cita creada con joins completos
            $cita = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'pacientes.telefono as paciente_telefono',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('citas.id', $citaId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Cita creada exitosamente',
                'data' => $cita
            ], 201);

        } catch (\Exception $e) {
            Log::error('CitaController@store - Error: ' . $e->getMessage());
            Log::error('CitaController@store - Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            Log::info('CitaController@show - Buscando cita con ID: ' . $id);

            $cita = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'pacientes.telefono as paciente_telefono',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('citas.id', $id)
                ->first();

            if (!$cita) {
                Log::warning('CitaController@show - Cita no encontrada con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ], 404);
            }

            Log::info('CitaController@show - Cita encontrada: ' . $cita->id);

            return response()->json([
                'success' => true,
                'data' => $cita
            ]);

        } catch (\Exception $e) {
            Log::error('CitaController@show - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('CitaController@update - Actualizando cita ID: ' . $id);
            Log::info('CitaController@update - Datos recibidos: ', $request->all());

            $cita = DB::table('citas')->where('id', $id)->first();
            if (!$cita) {
                Log::warning('CitaController@update - Cita no encontrada con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ], 404);
            }

            $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'medico_id' => 'required|exists:medicos,id',
                'fecha' => 'required|date_format:Y-m-d',
                'hora' => 'required|date_format:H:i:s',
                'motivo' => 'required|string',
                'observaciones' => 'nullable|string',
                'estado' => 'required|in:programada,confirmada,completada,cancelada'
            ]);

            // Combinar fecha y hora
            $fechaHora = $request->fecha . ' ' . $request->hora;
            $fechaHoraFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $fechaHora)->format('Y-m-d H:i:s');

            Log::info('CitaController@update - Fecha y hora combinadas: ' . $fechaHoraFormatted);

            DB::table('citas')->where('id', $id)->update([
                'paciente_id' => $request->paciente_id,
                'medico_id' => $request->medico_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'estado' => $request->estado,
                'updated_at' => now()
            ]);

            Log::info('CitaController@update - Cita actualizada exitosamente');

            // Obtener la cita actualizada con joins completos
            $citaActualizada = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'pacientes.telefono as paciente_telefono',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('citas.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Cita actualizada exitosamente',
                'data' => $citaActualizada
            ]);

        } catch (\Exception $e) {
            Log::error('CitaController@update - Error: ' . $e->getMessage());
            Log::error('CitaController@update - Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('CitaController@destroy - Eliminando cita con ID: ' . $id);

            $cita = DB::table('citas')->where('id', $id)->first();
            if (!$cita) {
                Log::warning('CitaController@destroy - Cita no encontrada con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ], 404);
            }

            DB::table('citas')->where('id', $id)->delete();

            Log::info('CitaController@destroy - Cita eliminada exitosamente');

            return response()->json([
                'success' => true,
                'message' => 'Cita eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('CitaController@destroy - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar cita: ' . $e->getMessage()
            ], 500);
        }
    }
}
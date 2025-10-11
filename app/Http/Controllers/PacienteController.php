<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PacienteController extends Controller
{
    public function index()
    {
        try {
            $pacientes = DB::table('pacientes')
                ->select('pacientes.*')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pacientes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pacientes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'apellido' => 'required|string',
                'email' => 'required|email|unique:pacientes,email',
                'password' => 'required|string|min:6',
                'telefono' => 'required|string',
                'fecha_nacimiento' => 'nullable|date',
                'tipo_documento' => 'nullable|string',
                'numero_documento' => 'nullable|string',
                'direccion' => 'nullable|string'
            ]);

            $pacienteId = DB::table('pacientes')->insertGetId([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'direccion' => $request->direccion,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $paciente = DB::table('pacientes')
                ->select('pacientes.*')
                ->where('pacientes.id', $pacienteId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Paciente creado exitosamente',
                'data' => $paciente
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear paciente: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $paciente = DB::table('pacientes')
                ->select('pacientes.*')
                ->where('pacientes.id', $id)
                ->first();

            if (!$paciente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paciente no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $paciente
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paciente = DB::table('pacientes')->where('id', $id)->first();
            if (!$paciente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paciente no encontrado'
                ], 404);
            }

            $request->validate([
                'nombre' => 'required|string',
                'apellido' => 'required|string',
                'telefono' => 'required|string',
                'fecha_nacimiento' => 'required|date',
                'tipo_documento' => 'required|string',
                'numero_documento' => 'required|string',
                'direccion' => 'required|string'
            ]);

            DB::table('pacientes')->where('id', $id)->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'direccion' => $request->direccion,
                'updated_at' => now()
            ]);

            $pacienteActualizado = DB::table('pacientes')
                ->select('pacientes.*')
                ->where('pacientes.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Paciente actualizado exitosamente',
                'data' => $pacienteActualizado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $paciente = DB::table('pacientes')->where('id', $id)->first();
            if (!$paciente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paciente no encontrado'
                ], 404);
            }

            DB::table('pacientes')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Paciente eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar paciente: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================
    // 🔹 FUNCIONES ESPECÍFICAS PARA PACIENTES
    // ==========================

    public function getMisCitas(Request $request)
    {
        try {
            // Obtener el ID del paciente del token (por ahora usamos un parámetro)
            $pacienteId = $request->get('paciente_id', 1); // Temporal, después se obtendrá del token

            Log::info('PacienteController@getMisCitas - Paciente ID: ' . $pacienteId);

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
                ->where('citas.paciente_id', $pacienteId)
                ->orderBy('citas.fecha', 'desc')
                ->orderBy('citas.hora', 'desc')
                ->get();

            Log::info('PacienteController@getMisCitas - Citas encontradas: ' . $citas->count());

            return response()->json([
                'success' => true,
                'data' => $citas
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener citas del paciente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener citas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function agendarCita(Request $request)
    {
        try {
            Log::info('PacienteController@agendarCita - Datos recibidos: ', $request->all());

            $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'medico_id' => 'required|exists:medicos,id',
                'fecha' => 'required|date_format:Y-m-d',
                'hora' => 'required|date_format:H:i:s',
                'motivo' => 'required|string',
                'estado' => 'nullable|in:programada,confirmada,completada,cancelada'
            ]);

            // Combinar fecha y hora
            $fechaHora = $request->fecha . ' ' . $request->hora;
            $fechaHoraFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $fechaHora)->format('Y-m-d H:i:s');

            Log::info('PacienteController@agendarCita - Fecha y hora combinadas: ' . $fechaHoraFormatted);

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

            Log::info('PacienteController@agendarCita - Cita creada con ID: ' . $citaId);

            // Obtener la cita creada con joins completos
            $cita = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('citas.id', $citaId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Cita agendada exitosamente',
                'data' => $cita
            ], 201);

        } catch (\Exception $e) {
            Log::error('PacienteController@agendarCita - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agendar cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancelarCita(Request $request, $citaId)
    {
        try {
            $cita = DB::table('citas')->where('id', $citaId)->first();
            if (!$cita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ], 404);
            }

            DB::table('citas')->where('id', $citaId)->update([
                'estado' => 'cancelada',
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cita cancelada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al cancelar cita: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProximaCita(Request $request)
    {
        try {
            $pacienteId = $request->get('paciente_id', 1); // Temporal

            Log::info('PacienteController@getProximaCita - Paciente ID: ' . $pacienteId);

            $proximaCita = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('citas.paciente_id', $pacienteId)
                ->where('citas.estado', '!=', 'cancelada')
                ->where('citas.estado', '!=', 'completada')
                ->whereDate('citas.fecha', '>=', now()->toDateString())
                ->orderBy('citas.fecha', 'asc')
                ->orderBy('citas.hora', 'asc')
                ->first();

            Log::info('PacienteController@getProximaCita - Próxima cita encontrada: ' . ($proximaCita ? 'Sí' : 'No'));

            return response()->json([
                'success' => true,
                'data' => $proximaCita
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener próxima cita del paciente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener próxima cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMiHistorial(Request $request)
    {
        try {
            $pacienteId = $request->get('paciente_id', 1); // Temporal

            $historial = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'citas.*',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'medicos.nombre as medico_nombre',
                    'medicos.apellido as medico_apellido',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('citas.paciente_id', $pacienteId)
                ->orderBy('citas.fecha', 'desc')
                ->orderBy('citas.hora', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $historial
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener historial del paciente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener historial: ' . $e->getMessage()
            ], 500);
        }
    }
}
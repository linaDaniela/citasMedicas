<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MedicoController extends Controller
{
    public function index()
    {
        try {
            $medicos = DB::table('medicos')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'medicos.*',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $medicos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener médicos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'apellido' => 'required|string',
                'email' => 'required|email|unique:medicos,email',
                'password' => 'required|string|min:6',
                'telefono' => 'required|string',
                'numero_licencia' => 'required|string|unique:medicos,numero_licencia',
                'especialidad_id' => 'required|exists:especialidades,id'
            ]);

            $medicoId = DB::table('medicos')->insertGetId([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'numero_licencia' => $request->numero_licencia,
                'especialidad_id' => $request->especialidad_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $medico = DB::table('medicos')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'medicos.*',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('medicos.id', $medicoId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Médico creado exitosamente',
                'data' => $medico
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear médico: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $medico = DB::table('medicos')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'medicos.*',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('medicos.id', $id)
                ->first();

            if (!$medico) {
                return response()->json([
                    'success' => false,
                    'message' => 'Médico no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $medico
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
            $medico = DB::table('medicos')->where('id', $id)->first();
            if (!$medico) {
                return response()->json([
                    'success' => false,
                    'message' => 'Médico no encontrado'
                ], 404);
            }

            $request->validate([
                'nombre' => 'required|string',
                'apellido' => 'required|string',
                'telefono' => 'required|string',
                'especialidad_id' => 'required|exists:especialidades,id'
            ]);

            DB::table('medicos')->where('id', $id)->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
                'especialidad_id' => $request->especialidad_id,
                'updated_at' => now()
            ]);

            $medicoActualizado = DB::table('medicos')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->select(
                    'medicos.*',
                    'especialidades.nombre as especialidad_nombre'
                )
                ->where('medicos.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Médico actualizado exitosamente',
                'data' => $medicoActualizado
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
            $medico = DB::table('medicos')->where('id', $id)->first();
            if (!$medico) {
                return response()->json([
                    'success' => false,
                    'message' => 'Médico no encontrado'
                ], 404);
            }

            DB::table('medicos')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Médico eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar médico: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================
    // 🔹 FUNCIONES ESPECÍFICAS PARA MÉDICOS
    // ==========================

    public function getMisCitas(Request $request)
    {
        try {
            // Obtener el ID del médico del token (por ahora usamos un parámetro)
            $medicoId = $request->get('medico_id', 1); // Temporal, después se obtendrá del token

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
                ->where('citas.medico_id', $medicoId)
                ->orderBy('citas.fecha', 'asc')
                ->orderBy('citas.hora', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $citas
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener citas del médico: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener citas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMisPacientes(Request $request)
    {
        try {
            $medicoId = $request->get('medico_id', 1); // Temporal

            $pacientes = DB::table('citas')
                ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
                ->select(
                    'pacientes.*',
                    DB::raw('COUNT(citas.id) as total_citas'),
                    DB::raw('MAX(citas.fecha) as ultima_cita')
                )
                ->where('citas.medico_id', $medicoId)
                ->groupBy('pacientes.id')
                ->orderBy('pacientes.nombre', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pacientes
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener pacientes del médico: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pacientes: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================
    // 🔹 NUEVA FUNCIÓN PARA LA AGENDA
    // ==========================

    public function getMiAgenda(Request $request)
    {
        try {
            // Obtener el ID del médico del token (por ahora usamos un parámetro)
            $medicoId = $request->get('medico_id', 1); // Temporal, después se obtendrá del token

            Log::info('MedicoController@getMiAgenda - Médico ID: ' . $medicoId);

            $agenda = DB::table('citas')
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
                ->where('citas.medico_id', $medicoId)
                ->where('citas.fecha', '>=', now()->format('Y-m-d')) // Solo citas futuras
                ->orderBy('citas.fecha', 'asc')
                ->orderBy('citas.hora', 'asc')
                ->get();

            Log::info('MedicoController@getMiAgenda - Citas encontradas: ' . $agenda->count());

            return response()->json([
                'success' => true,
                'data' => $agenda
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener agenda del médico: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener agenda: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================
    // 🔹 NUEVA FUNCIÓN PARA LOS REPORTES
    // ==========================

    public function getReportes(Request $request)
    {
        try {
            $medicoId = $request->get('medico_id', 1); // Temporal
            $periodo = $request->get('periodo', 'hoy'); // hoy, semana, mes

            Log::info('MedicoController@getReportes - Médico ID: ' . $medicoId . ', Período: ' . $periodo);

            // Calcular fechas según el período
            $fechaInicio = now();
            $fechaFin = now();
            
            switch ($periodo) {
                case 'semana':
                    $fechaInicio = now()->startOfWeek();
                    $fechaFin = now()->endOfWeek();
                    break;
                case 'mes':
                    $fechaInicio = now()->startOfMonth();
                    $fechaFin = now()->endOfMonth();
                    break;
                default: // hoy
                    $fechaInicio = now()->startOfDay();
                    $fechaFin = now()->endOfDay();
                    break;
            }

            // Obtener estadísticas de citas
            $citasTotal = DB::table('citas')
                ->where('medico_id', $medicoId)
                ->whereBetween('fecha', [$fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d')])
                ->count();

            $citasCompletadas = DB::table('citas')
                ->where('medico_id', $medicoId)
                ->where('estado', 'completada')
                ->whereBetween('fecha', [$fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d')])
                ->count();

            $citasCanceladas = DB::table('citas')
                ->where('medico_id', $medicoId)
                ->where('estado', 'cancelada')
                ->whereBetween('fecha', [$fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d')])
                ->count();

            // Obtener pacientes únicos atendidos
            $pacientesAtendidos = DB::table('citas')
                ->where('medico_id', $medicoId)
                ->whereBetween('fecha', [$fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d')])
                ->distinct('paciente_id')
                ->count('paciente_id');

            // Obtener especialidad más común
            $especialidadMasComun = DB::table('citas')
                ->leftJoin('medicos', 'citas.medico_id', '=', 'medicos.id')
                ->leftJoin('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
                ->where('citas.medico_id', $medicoId)
                ->whereBetween('citas.fecha', [$fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d')])
                ->select('especialidades.nombre', DB::raw('COUNT(*) as total'))
                ->groupBy('especialidades.id', 'especialidades.nombre')
                ->orderBy('total', 'desc')
                ->first();

            // Obtener hora más común de citas
            $horaMasComun = DB::table('citas')
                ->where('citas.medico_id', $medicoId)
                ->whereBetween('citas.fecha', [$fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d')])
                ->select('citas.hora', DB::raw('COUNT(*) as total'))
                ->groupBy('citas.hora')
                ->orderBy('total', 'desc')
                ->first();

            $reportes = [
                'citasTotal' => $citasTotal,
                'citasCompletadas' => $citasCompletadas,
                'citasCanceladas' => $citasCanceladas,
                'pacientesAtendidos' => $pacientesAtendidos,
                'especialidadMasComun' => $especialidadMasComun->nombre ?? 'N/A',
                'horaMasComun' => $horaMasComun->hora ?? 'N/A',
                'periodo' => $periodo,
                'fechaInicio' => $fechaInicio->format('Y-m-d'),
                'fechaFin' => $fechaFin->format('Y-m-d')
            ];

            Log::info('MedicoController@getReportes - Reportes generados:', $reportes);

            return response()->json([
                'success' => true,
                'data' => $reportes
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener reportes del médico: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener reportes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizarEstadoCita(Request $request, $citaId)
    {
        try {
            $request->validate([
                'estado' => 'required|in:programada,confirmada,completada,cancelada'
            ]);

            $cita = DB::table('citas')->where('id', $citaId)->first();
            if (!$cita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ], 404);
            }

            DB::table('citas')->where('id', $citaId)->update([
                'estado' => $request->estado,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado de cita actualizado exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar estado de cita: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function agregarObservaciones(Request $request, $citaId)
    {
        try {
            $request->validate([
                'observaciones' => 'required|string'
            ]);

            $cita = DB::table('citas')->where('id', $citaId)->first();
            if (!$cita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ], 404);
            }

            DB::table('citas')->where('id', $citaId)->update([
                'observaciones' => $request->observaciones,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Observaciones agregadas exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al agregar observaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar observaciones: ' . $e->getMessage()
            ], 500);
        }
    }
}
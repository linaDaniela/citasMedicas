<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    protected $table = 'historial_medico';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'cita_id',
        'fecha_consulta',
        'motivo_consulta',
        'sintomas',
        'diagnostico',
        'tratamiento',
        'medicamentos_recetados',
        'observaciones',
        'archivos_adjuntos',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
        'archivos_adjuntos' => 'array',
    ];

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medicos::class);
    }

    public function cita()
    {
        return $this->belongsTo(Citas::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'consultorio_id',
        'fecha_cita',
        'hora_cita',
        'duracion_minutos',
        'motivo',
        'estado',
        'observaciones',
        'diagnostico',
        'tratamiento',
        'proxima_cita',
    ];

    protected $casts = [
        'fecha_cita' => 'date',
        'hora_cita' => 'datetime:H:i',
        'proxima_cita' => 'date',
    ];

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medicos::class);
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorios::class);
    }

    public function historialMedico()
    {
        return $this->hasMany(HistorialMedico::class);
    }

    public function recetasMedicas()
    {
        return $this->hasMany(RecetasMedicas::class);
    }
}

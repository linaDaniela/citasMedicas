<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidad_id',
        'fecha_hora',
        'estado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function pacientes()
    {
        return $this->belongsTo(Pacientes::class);
    }

    public function medicos()
    {
        return $this->belongsTo(Medicos::class);
    }

    public function especialidades()
    {
        return $this->belongsTo(Especialidades::class);
    }
}

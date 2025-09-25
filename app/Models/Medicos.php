<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicos extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'especialidad_id',
        'telefono',
        'email',
        'direccion',
        'experiencia_anos',
        'consultorio_id',
        'horario_inicio',
        'horario_fin',
        'dias_trabajo',
        'tarifa_consulta',
        'estado',
    ];

    protected $casts = [
        'horario_inicio' => 'datetime:H:i',
        'horario_fin' => 'datetime:H:i',
        'tarifa_consulta' => 'decimal:2',
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidades::class);
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorios::class);
    }

    public function citas()
    {
        return $this->hasMany(Citas::class);
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

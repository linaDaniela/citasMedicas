<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Historiales;

class Pacientes extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
        'eps_id',
        'tipo_afiliacion',
        'numero_afiliacion',
        'grupo_sanguineo',
        'alergias',
        'medicamentos_actuales',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    protected $appends = ['edad'];

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    public function eps()
    {
        return $this->belongsTo(Eps::class);
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

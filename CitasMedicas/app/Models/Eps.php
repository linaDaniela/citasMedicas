<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    protected $table = 'eps';

    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'email',
        'sitio_web',
        'representante_legal',
        'telefono_representante',
        'email_representante',
        'tipo_eps',
        'estado',
        'fecha_afiliacion',
        'total_afiliados',
        'total_medicos',
        'total_consultorios',
        'calificacion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_afiliacion' => 'date',
        'calificacion' => 'decimal:1',
    ];

    public function pacientes()
    {
        return $this->hasMany(Pacientes::class);
    }
}

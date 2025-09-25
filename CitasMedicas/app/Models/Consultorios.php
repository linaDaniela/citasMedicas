<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorios extends Model
{
    protected $table = 'consultorios';

    protected $fillable = [
        'nombre',
        'numero',
        'piso',
        'edificio',
        'direccion',
        'telefono',
        'capacidad_pacientes',
        'equipos_medicos',
        'estado',
    ];

    public function medicos()
    {
        return $this->hasMany(Medicos::class);
    }

    public function citas()
    {
        return $this->hasMany(Citas::class);
    }
}
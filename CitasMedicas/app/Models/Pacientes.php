<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'numero_documento',
        'fecha_nacimiento',
        'email',
        'telefono',
        'genero',
    ];

    public function citas()
    {
        return $this->hasMany(Citas::class);
    }

    public function historiales()
    {
        return $this->hasMany(Historiales::class);
    }
}

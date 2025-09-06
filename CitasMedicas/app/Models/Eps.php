<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    protected $table = 'eps';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
    ];

    public function especialidades()
    {
        return $this->hasMany(Especialidades::class);
    }

    public function pacientes()
    {
        return $this->hasMany(Pacientes::class);
    }
}

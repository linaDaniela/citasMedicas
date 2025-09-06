<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicos extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'nombre',
        'apellido',
        'numero_documento',
        'email',
        'telefono',
        'especialidad_id',
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidades::class);
    }

    public function citas()
    {
        return $this->hasMany(Citas::class);
    }
}

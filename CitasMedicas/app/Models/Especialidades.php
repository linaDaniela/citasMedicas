<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function medicos()
    {
        return $this->hasMany(Medicos::class);
    }

    public function citas()
    {
        return $this->hasMany(Citas::class);
    }

    public function eps()
    {
        return $this->belongsTo(Eps::class);
    }
}

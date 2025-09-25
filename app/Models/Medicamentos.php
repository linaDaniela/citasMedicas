<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamentos extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'nombre',
        'principio_activo',
        'laboratorio',
        'presentacion',
        'dosis',
        'indicaciones',
        'contraindicaciones',
        'efectos_secundarios',
        'precio',
        'stock',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function detalleRecetas()
    {
        return $this->hasMany(DetalleRecetas::class);
    }
}
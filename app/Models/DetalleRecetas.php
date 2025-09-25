<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRecetas extends Model
{
    protected $table = 'detalle_recetas';

    protected $fillable = [
        'receta_id',
        'medicamento_id',
        'cantidad',
        'dosis',
        'frecuencia',
        'duracion',
        'observaciones',
    ];

    public function receta()
    {
        return $this->belongsTo(RecetasMedicas::class, 'receta_id');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamentos::class);
    }
}
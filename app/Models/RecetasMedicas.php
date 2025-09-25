<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetasMedicas extends Model
{
    protected $table = 'recetas_medicas';

    protected $fillable = [
        'cita_id',
        'paciente_id',
        'medico_id',
        'fecha_receta',
        'instrucciones',
        'estado',
    ];

    protected $casts = [
        'fecha_receta' => 'datetime',
    ];

    public function cita()
    {
        return $this->belongsTo(Citas::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medicos::class);
    }

    public function detalleRecetas()
    {
        return $this->hasMany(DetalleRecetas::class, 'receta_id');
    }
}
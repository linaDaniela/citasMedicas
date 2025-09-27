<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Medicos extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'medicos';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'especialidad_id',
        'telefono',
        'email',
        'usuario',
        'password',
        'estado_auth',
        'direccion',
        'experiencia_anos',
        'consultorio_id',
        'horario_inicio',
        'horario_fin',
        'dias_trabajo',
        'tarifa_consulta',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'horario_inicio' => 'datetime:H:i',
            'horario_fin' => 'datetime:H:i',
            'tarifa_consulta' => 'decimal:2'
        ];
    }

    // Relaciones
    public function especialidad()
    {
        return $this->belongsTo(Especialidades::class, 'especialidad_id');
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorios::class, 'consultorio_id');
    }

    public function citas()
    {
        return $this->hasMany(Citas::class, 'medico_id');
    }

    public function historialMedico()
    {
        return $this->hasMany(HistorialMedico::class, 'medico_id');
    }
}
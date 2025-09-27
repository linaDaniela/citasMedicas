<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pacientes extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'fecha_nacimiento',
        'telefono',
        'email',
        'usuario',
        'password',
        'estado_auth',
        'direccion',
        'eps_id',
        'tipo_afiliacion',
        'numero_afiliacion',
        'grupo_sanguineo',
        'alergias',
        'medicamentos_actuales',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
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
            'fecha_nacimiento' => 'date'
        ];
    }

    // Relaciones
    public function eps()
    {
        return $this->belongsTo(Eps::class, 'eps_id');
    }

    public function citas()
    {
        return $this->hasMany(Citas::class, 'paciente_id');
    }

    public function historialMedico()
    {
        return $this->hasMany(HistorialMedico::class, 'paciente_id');
    }
}
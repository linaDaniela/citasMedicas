<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrador extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'administradores';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'usuario',
        'password',
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
        ];
    }

    // Método para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    // Método para verificar si el administrador está activo
    public function isActive()
    {
        return $this->estado === 'activo';
    }

    // Scope para filtrar solo administradores activos
    public function scopeActive($query)
    {
        return $query->where('estado', 'activo');
    }

    // Método para verificar si el usuario puede autenticarse
    public function canAuthenticate()
    {
        return $this->isActive() && !empty($this->email) && !empty($this->password);
    }
}
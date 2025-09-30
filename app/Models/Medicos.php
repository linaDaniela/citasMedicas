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

    // Métodos de autenticación y estado
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function isActive()
    {
        return $this->estado_auth === 'activo';
    }

    public function scopeActive($query)
    {
        return $query->where('estado_auth', 'activo');
    }

    public function canAuthenticate()
    {
        return $this->isActive() && !empty($this->email) && !empty($this->password);
    }

    // Métodos específicos para médicos
    public function getEspecialidadNombreAttribute()
    {
        return $this->especialidad ? $this->especialidad->nombre : 'Sin especialidad';
    }

    public function getConsultorioNombreAttribute()
    {
        return $this->consultorio ? $this->consultorio->nombre : 'Sin consultorio asignado';
    }

    public function getHorarioTrabajoAttribute()
    {
        if ($this->horario_inicio && $this->horario_fin) {
            return $this->horario_inicio->format('H:i') . ' - ' . $this->horario_fin->format('H:i');
        }
        return 'Horario no definido';
    }

    public function getDiasTrabajoArrayAttribute()
    {
        if ($this->dias_trabajo) {
            return explode(',', $this->dias_trabajo);
        }
        return [];
    }

    public function getTarifaFormateadaAttribute()
    {
        if ($this->tarifa_consulta) {
            return '$' . number_format($this->tarifa_consulta, 2);
        }
        return 'No definida';
    }

    public function getExperienciaTextoAttribute()
    {
        $anos = $this->experiencia_anos ?? 0;
        if ($anos === 0) {
            return 'Sin experiencia';
        } elseif ($anos === 1) {
            return '1 año de experiencia';
        } else {
            return $anos . ' años de experiencia';
        }
    }

    // Scopes adicionales
    public function scopePorEspecialidad($query, $especialidadId)
    {
        return $query->where('especialidad_id', $especialidadId);
    }

    public function scopePorConsultorio($query, $consultorioId)
    {
        return $query->where('consultorio_id', $consultorioId);
    }

    public function scopeConEspecialidad($query)
    {
        return $query->with('especialidad');
    }

    public function scopeConConsultorio($query)
    {
        return $query->with('consultorio');
    }

    // Método para verificar disponibilidad
    public function estaDisponible($fecha, $hora)
    {
        // Verificar si el médico está activo
        if (!$this->isActive()) {
            return false;
        }

        // Verificar si tiene citas en esa fecha y hora
        $citaExistente = $this->citas()
            ->where('fecha_cita', $fecha)
            ->where('hora_cita', $hora)
            ->where('estado', '!=', 'cancelada')
            ->exists();

        return !$citaExistente;
    }

    // Método para obtener estadísticas del médico
    public function getEstadisticasAttribute()
    {
        $totalCitas = $this->citas()->count();
        $citasCompletadas = $this->citas()->where('estado', 'completada')->count();
        $citasCanceladas = $this->citas()->where('estado', 'cancelada')->count();
        $citasPendientes = $this->citas()->where('estado', 'pendiente')->count();

        return [
            'total_citas' => $totalCitas,
            'citas_completadas' => $citasCompletadas,
            'citas_canceladas' => $citasCanceladas,
            'citas_pendientes' => $citasPendientes,
            'porcentaje_completadas' => $totalCitas > 0 ? round(($citasCompletadas / $totalCitas) * 100, 2) : 0
        ];
    }
}
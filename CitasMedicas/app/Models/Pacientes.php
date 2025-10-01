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
            'fecha_nacimiento' => 'date',
            'estado' => 'boolean',
            'estado_auth' => 'boolean'
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

    // Alias para compatibilidad con el controlador anterior
    public function historiales()
    {
        return $this->historialMedico();
    }

    // Métodos de autenticación y estado
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }

    public function isActive()
    {
        return $this->estado_auth === true || $this->estado_auth === 'activo';
    }

    public function scopeActive($query)
    {
        return $query->where('estado_auth', 'activo');
    }

    public function canAuthenticate()
    {
        return $this->isActive() && !empty($this->email) && !empty($this->password);
    }

    // Accessors para datos calculados
    public function getEdadAttribute()
    {
        if (!$this->fecha_nacimiento) {
            return null;
        }
        
        return $this->fecha_nacimiento->age;
    }

    public function getEpsNombreAttribute()
    {
        return $this->eps ? $this->eps->nombre : 'Sin EPS asignada';
    }

    public function getTipoAfiliacionTextoAttribute()
    {
        return $this->tipo_afiliacion ? ucfirst(strtolower($this->tipo_afiliacion)) : 'No especificado';
    }

    public function getGrupoSanguineoTextoAttribute()
    {
        return $this->grupo_sanguineo ?: 'No especificado';
    }

    public function getAlergiasTextoAttribute()
    {
        return $this->alergias ?: 'Ninguna alergia registrada';
    }

    public function getMedicamentosTextoAttribute()
    {
        return $this->medicamentos_actuales ?: 'Ningún medicamento registrado';
    }

    public function getContactoEmergenciaCompletoAttribute()
    {
        if ($this->contacto_emergencia_nombre && $this->contacto_emergencia_telefono) {
            return $this->contacto_emergencia_nombre . ' - ' . $this->contacto_emergencia_telefono;
        }
        return 'No especificado';
    }

    public function getDireccionCompletaAttribute()
    {
        return $this->direccion ?: 'Dirección no especificada';
    }

    // Scopes útiles
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorEps($query, $epsId)
    {
        return $query->where('eps_id', $epsId);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
              ->orWhere('apellido', 'like', "%{$termino}%")
              ->orWhere('cedula', 'like', "%{$termino}%")
              ->orWhere('email', 'like', "%{$termino}%");
        });
    }

    public function scopeConEps($query)
    {
        return $query->with('eps');
    }

    public function scopePorTipoAfiliacion($query, $tipo)
    {
        return $query->where('tipo_afiliacion', $tipo);
    }

    public function scopePorGrupoSanguineo($query, $grupo)
    {
        return $query->where('grupo_sanguineo', $grupo);
    }

    // Métodos específicos para pacientes
    public function tieneAlergias()
    {
        return !empty($this->alergias);
    }

    public function tomaMedicamentos()
    {
        return !empty($this->medicamentos_actuales);
    }

    public function tieneContactoEmergencia()
    {
        return !empty($this->contacto_emergencia_nombre) && !empty($this->contacto_emergencia_telefono);
    }

    public function esCotizante()
    {
        return $this->tipo_afiliacion === 'Cotizante';
    }

    public function esBeneficiario()
    {
        return $this->tipo_afiliacion === 'Beneficiario';
    }

    // Método para obtener estadísticas del paciente
    public function getEstadisticasAttribute()
    {
        $totalCitas = $this->citas()->count();
        $citasCompletadas = $this->citas()->where('estado', 'completada')->count();
        $citasCanceladas = $this->citas()->where('estado', 'cancelada')->count();
        $citasPendientes = $this->citas()->where('estado', 'pendiente')->count();
        $totalHistoriales = $this->historialMedico()->count();

        return [
            'total_citas' => $totalCitas,
            'citas_completadas' => $citasCompletadas,
            'citas_canceladas' => $citasCanceladas,
            'citas_pendientes' => $citasPendientes,
            'total_historiales' => $totalHistoriales,
            'porcentaje_completadas' => $totalCitas > 0 ? round(($citasCompletadas / $totalCitas) * 100, 2) : 0
        ];
    }

    // Método para verificar si puede agendar cita
    public function puedeAgendarCita()
    {
        return $this->isActive() && !empty($this->eps_id);
    }

    // Método para obtener información médica resumida
    public function getInfoMedicaResumidaAttribute()
    {
        $info = [];
        
        if ($this->grupo_sanguineo) {
            $info[] = "Grupo sanguíneo: {$this->grupo_sanguineo}";
        }
        
        if ($this->alergias) {
            $info[] = "Alergias: {$this->alergias}";
        }
        
        if ($this->medicamentos_actuales) {
            $info[] = "Medicamentos: {$this->medicamentos_actuales}";
        }
        
        return implode(' | ', $info) ?: 'Sin información médica adicional';
    }

    // Método para obtener próximas citas
    public function getProximasCitasAttribute()
    {
        return $this->citas()
            ->where('fecha_cita', '>=', now())
            ->where('estado', '!=', 'cancelada')
            ->orderBy('fecha_cita')
            ->orderBy('hora_cita')
            ->get();
    }

    // Método para obtener historial médico reciente
    public function getHistorialRecienteAttribute()
    {
        return $this->historialMedico()
            ->orderBy('fecha_consulta', 'desc')
            ->limit(5)
            ->get();
    }
}
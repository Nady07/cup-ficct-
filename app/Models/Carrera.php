<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    /**
     * Atributos asignables masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'duracion',
        'titulo_otorgado',
        'cupos',        // ← CAMPO NUEVO REQUERIDO POR EL EXAMEN
        'estado',
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estado' => 'boolean',
        'cupos'  => 'integer',
    ];

    // =========================================================================
    // RELACIONES
    // =========================================================================

    /**
     * Estudiantes que eligieron esta carrera como PRIMERA opción.
     *
     * @return HasMany
     */
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'carrera_interes_id');
    }

    /**
     * Estudiantes que eligieron esta carrera como SEGUNDA opción.
     *
     * @return HasMany
     */
    public function estudiantesSegundaOpcion(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'carrera_opcion2_id');
    }

    // =========================================================================
    // MÉTODOS DE LÓGICA DE NEGOCIO
    // =========================================================================

    /**
     * Calcula los cupos disponibles.
     *
     * @return int
     */
    public function cuposDisponibles(): int
    {
        $inscritos = $this->estudiantes()->count();
        return max($this->cupos - $inscritos, 0);
    }

    /**
     * Verifica si la carrera tiene cupos disponibles.
     *
     * @return bool
     */
    public function tieneCupos(): bool
    {
        return $this->cuposDisponibles() > 0;
    }

    /**
     * Calcula el porcentaje de ocupación de cupos.
     *
     * @return float
     */
    public function porcentajeOcupacion(): float
    {
        if ($this->cupos <= 0) {
            return 0;
        }
        $inscritos = $this->estudiantes()->count();
        return round(($inscritos / $this->cupos) * 100, 1);
    }

    /**
     * Obtiene el total de estudiantes inscritos (primera opción).
     *
     * @return int
     */
    public function totalInscritos(): int
    {
        return $this->estudiantes()->count();
    }

    // =========================================================================
    // ACCESORES
    // =========================================================================

    /**
     * Accesor: Estado legible de la carrera.
     * Uso: $carrera->estado_legible
     *
     * @return string
     */
    public function getEstadoLegibleAttribute(): string
    {
        return $this->estado ? 'Activa ✅' : 'Inactiva ❌';
    }

    /**
     * Accesor: Porcentaje de ocupación formateado.
     * Uso: $carrera->porcentaje_ocupacion_formateado
     *
     * @return string
     */
    public function getPorcentajeOcupacionFormateadoAttribute(): string
    {
        return $this->porcentajeOcupacion() . '%';
    }
}
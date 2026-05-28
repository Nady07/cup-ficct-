<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    /**
     * CAPACIDAD MÁXIMA POR GRUPO SEGÚN EL EXAMEN.
     * "Cada grupo admite máximo 70 estudiantes"
     * "Fórmula: CEIL(TotalInscritos / 80)"
     * Usamos 80 para el cálculo de grupos necesarios.
     */
    const CAPACIDAD_POR_GRUPO = 70;  // Capacidad real
    const FORMULA_DIVISOR = 80;      // Divisor para cálculo de grupos

    protected $fillable = [
        'codigo',
        'turno',
        'horario_inicio',
        'horario_fin',
        'capacidad_maxima',
        'estudiantes_inscritos',
        'docente_id',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'capacidad_maxima' => 'integer',
        'estudiantes_inscritos' => 'integer',
    ];

    // =========================================================================
    // RELACIONES
    // =========================================================================

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    // =========================================================================
    // MÉTODOS DE NEGOCIO
    // =========================================================================

    /**
     * Verificar si el grupo tiene cupos disponibles.
     */
    public function tieneCupo(): bool
    {
        return $this->estudiantes_inscritos < $this->capacidad_maxima;
    }

    /**
     * Calcular cupos disponibles.
     */
    public function cuposDisponibles(): int
    {
        return max($this->capacidad_maxima - $this->estudiantes_inscritos, 0);
    }

    /**
     * Calcular cuántos grupos se necesitan según inscritos confirmados.
     * Fórmula del examen: CEIL(TotalInscritos / 80)
     */
    public static function calcularGruposNecesarios(): int
    {
        $totalInscritos = Inscripcion::where('estado', 'confirmado')->count();

        if ($totalInscritos === 0) {
            return 0;
        }

        return (int) ceil($totalInscritos / self::FORMULA_DIVISOR);
    }

    /**
     * Calcular grupos actuales vs necesarios.
     */
    public static function resumenGrupos(): array
    {
        $gruposActuales = self::count();
        $gruposNecesarios = self::calcularGruposNecesarios();
        $totalInscritos = Inscripcion::where('estado', 'confirmado')->count();
        $capacidadTotal = $gruposActuales * self::CAPACIDAD_POR_GRUPO;
        $cuposDisponibles = $capacidadTotal - $totalInscritos;

        return [
            'total_inscritos'    => $totalInscritos,
            'grupos_actuales'    => $gruposActuales,
            'grupos_necesarios'  => $gruposNecesarios,
            'capacidad_total'    => $capacidadTotal,
            'cupos_disponibles'  => max($cuposDisponibles, 0),
            'faltan_grupos'      => max($gruposNecesarios - $gruposActuales, 0),
            'sobran_grupos'      => max($gruposActuales - $gruposNecesarios, 0),
        ];
    }

    // =========================================================================
    // ACCESORES
    // =========================================================================

    /**
     * Turno legible.
     */
    public function getTurnoLegibleAttribute(): string
    {
        return match($this->turno) {
            'M' => 'Mañana',
            'T' => 'Tarde',
            'N' => 'Noche',
            default => $this->turno,
        };
    }

    /**
     * Horario completo formateado.
     */
    public function getHorarioCompletoAttribute(): string
    {
        return $this->horario_inicio . ' - ' . $this->horario_fin;
    }

    /**
     * Porcentaje de ocupación.
     */
    public function getPorcentajeOcupacionAttribute(): float
    {
        if ($this->capacidad_maxima <= 0) {
            return 0;
        }
        return round(($this->estudiantes_inscritos / $this->capacidad_maxima) * 100, 1);
    }
}
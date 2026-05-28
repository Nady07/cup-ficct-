<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'calificaciones';

    /**
     * Atributos asignables masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'estudiante_id',
        'materia_id',
        'nota1',
        'nota2',
        'nota3',
        'promedio',
        'estado',
        'registrado_por',
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nota1'    => 'float',
        'nota2'    => 'float',
        'nota3'    => 'float',
        'promedio' => 'float',
    ];

    /**
     * NOTA MÍNIMA DE APROBACIÓN SEGÚN EL EXAMEN.
     * Examen: "promedio >= 60 → APROBADO, Caso contrario → REPROBADO"
     */
    const NOTA_MINIMA_APROBACION = 60;

    // =========================================================================
    // MÉTODOS DE LÓGICA DE NEGOCIO
    // =========================================================================

    /**
     * Calcula el promedio de las tres notas.
     * Fórmula del examen: (Nota1 + Nota2 + Nota3) / 3
     *
     * @return float
     */
    public function calcularPromedio(): float
    {
        $promedio = ($this->nota1 + $this->nota2 + $this->nota3) / 3;
        $this->promedio = round($promedio, 2);
        
        return $this->promedio;
    }

    /**
     * Determina el estado del estudiante según el promedio obtenido.
     * Regla del examen: APROBADO >= 60, REPROBADO < 60
     *
     * @return string
     */
    public function determinarEstado(): string
    {
        $this->estado = $this->promedio >= self::NOTA_MINIMA_APROBACION 
            ? 'aprobado' 
            : 'reprobado';
        
        return $this->estado;
    }

    /**
     * Método combinado: calcula promedio y determina estado en una sola llamada.
     * Útil para el controlador cuando necesitas actualizar ambos valores.
     *
     * @return $this
     */
    public function calcularYActualizarEstado()
    {
        $this->calcularPromedio();
        $this->determinarEstado();
        
        return $this;
    }

    /**
     * Verifica si el estudiante aprobó.
     *
     * @return bool
     */
    public function estaAprobado(): bool
    {
        return $this->estado === 'aprobado';
    }

    // =========================================================================
    // ACCESORES (Se usan como propiedades: $calificacion->promedio_formateado)
    // =========================================================================

    /**
     * Accesor: Obtiene el promedio formateado con 2 decimales.
     * Uso en vistas: {{ $calificacion->promedio_formateado }}
     * Resultado: "85.50" en lugar de 85.5
     *
     * @return string
     */
    public function getPromedioFormateadoAttribute(): string
    {
        return number_format($this->promedio, 2);
    }

    /**
     * Accesor: Obtiene el estado en español con emoji indicativo.
     * Uso en vistas: {{ $calificacion->estado_legible }}
     * Resultado: "APROBADO ✅" o "REPROBADO ❌"
     *
     * @return string
     */
    public function getEstadoLegibleAttribute(): string
    {
        return $this->estado === 'aprobado' 
            ? 'APROBADO ✅' 
            : 'REPROBADO ❌';
    }

    /**
     * Accesor: Devuelve la clase CSS según el estado.
     * Uso en vistas: <span class="badge bg-{{ $calificacion->color_estado }}">
     * Resultado: "success" (verde) o "danger" (rojo)
     *
     * @return string
     */
    public function getColorEstadoAttribute(): string
    {
        return $this->estado === 'aprobado' ? 'success' : 'danger';
    }

    // =========================================================================
    // RELACIONES
    // =========================================================================

    /**
     * Relación: Calificación pertenece a un Estudiante.
     *
     * @return BelongsTo
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Relación: Calificación pertenece a una MateriaCup.
     *
     * @return BelongsTo
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(MateriaCup::class, 'materia_id');
    }

    /**
     * Relación: Quién registró esta calificación (Usuario administrador).
     *
     * @return BelongsTo
     */
    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
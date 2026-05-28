<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    protected $fillable = [
        'user_id',
        'ci',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'especialidad',
        'experiencia',
        'curriculum_path',
        'estado',
        'estado_postulacion',
        'motivo_rechazo',
        'fecha_postulacion',
        'fecha_revision',
        'revisado_por',
    ];

    protected $casts = [
        'fecha_postulacion' => 'datetime',
        'fecha_revision'    => 'datetime',
        'estado'            => 'boolean',
    ];

    // =========================================================================
    // RELACIONES
    // =========================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grupos(): HasMany
    {
        return $this->hasMany(Grupo::class);
    }

    public function requisitosPresentados(): HasMany
    {
        return $this->hasMany(DocenteRequisito::class);
    }

    // =========================================================================
    // MÉTODOS DE LÓGICA DE NEGOCIO
    // =========================================================================

    /**
     * Verificar si el docente cumple todos los requisitos obligatorios.
     */
    public function cumpleRequisitosObligatorios(): bool
    {
        $requisitosObligatorios = RequisitoCup::where('tipo', 'docente')
            ->where('obligatorio', true)
            ->where('estado', true)
            ->pluck('id');

        $presentados = $this->requisitosPresentados()
            ->where('presentado', true)
            ->whereIn('requisito_id', $requisitosObligatorios)
            ->count();

        return $presentados === $requisitosObligatorios->count();
    }

    /**
     * Revisar postulación del docente.
     */
    public function revisarPostulacion(bool $aprobado, ?string $motivo = null, ?int $revisadoPor = null): void
    {
        $this->update([
            'estado_postulacion' => $aprobado ? 'aprobado' : 'rechazado',
            'motivo_rechazo'     => $aprobado ? null : $motivo,
            'fecha_revision'     => now(),
            'revisado_por'       => $revisadoPor,
            'estado'             => $aprobado,
        ]);
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopePostulantes($query)
    {
        return $query->whereNotNull('fecha_postulacion');
    }

    public function scopeAprobados($query)
    {
        return $query->where('estado_postulacion', 'aprobado');
    }

    public function scopePendientesRevision($query)
    {
        return $query->whereIn('estado_postulacion', ['pendiente', 'en_revision']);
    }

    // =========================================================================
    // ACCESORES
    // =========================================================================

    /**
     * Nombre completo del docente.
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->apellidos . ' ' . $this->nombre;
    }

    /**
     * Estado legible de la postulación.
     */
    public function getEstadoPostulacionLegibleAttribute(): string
    {
        return match($this->estado_postulacion) {
            'pendiente'    => '⏳ Pendiente',
            'en_revision'  => '🔍 En Revisión',
            'aprobado'     => '✅ Aprobado',
            'rechazado'    => '❌ Rechazado',
            default       => '❓ Desconocido',
        };
    }
}
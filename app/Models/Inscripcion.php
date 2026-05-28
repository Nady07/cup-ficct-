<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = [
        'estudiante_id', 'grupo_id', 'fecha_inscripcion', 'estado',
        'comprobante_pago', 'monto_pagado', 'numero_boleta', 'requisitos_completos'
    ];

    // Relación con Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Relación con Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
    protected $casts = [
    'fecha_inscripcion' => 'datetime',
    'requisitos_completos' => 'boolean',
    'monto_pagado' => 'decimal:2',
];

// Accesor: Estado legible
    public function getEstadoLegibleAttribute(): string
    {
        return match($this->estado) {
            'pendiente'  => '⏳ Pendiente',
            'confirmado' => '✅ Confirmado',
            'rechazado'  => '❌ Rechazado',
            'completado' => '🎓 Completado',
            default      => $this->estado,
        };
    }
}
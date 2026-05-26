<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = [
        'estudiante_id', 'grupo_id', 'fecha_inscripcion', 'estado',
        'comprobante_pago', 'monto_pagado', 'numero_boleta', 'requisitos_completos'
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitoCup extends Model
{
    protected $table = 'requisitos_cup';

    protected $fillable = [
        'descripcion', 'tipo', 'obligatorio', 'estado', 'materia_id'
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo(MateriaCup::class, 'materia_id');
    }
    protected $casts = [
    'obligatorio' => 'boolean',
    'estado' => 'boolean',
    ];
}
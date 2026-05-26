<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'estudiante_id', 'materia_id', 'nota', 'estado', 'registrado_por'
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(MateriaCup::class, 'materia_id');
    }
}
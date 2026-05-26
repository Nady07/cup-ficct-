<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grupo extends Model
{
    protected $fillable = [
        'codigo', 'turno', 'horario_inicio', 'horario_fin',
        'capacidad_maxima', 'estudiantes_inscritos', 'docente_id', 'materia_id', 'estado'
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(MateriaCup::class, 'materia_id');
    }
}
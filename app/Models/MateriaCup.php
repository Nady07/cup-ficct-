<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MateriaCup extends Model
{
    protected $table = 'materias_cup';

    protected $fillable = [
        'nombre', 'codigo', 'descripcion', 'nota_minima', 'valor_puntaje', 'orden', 'estado'
    ];

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class, 'materia_id');
    }

    public function requisitos(): HasMany
    {
        return $this->hasMany(RequisitoCup::class, 'materia_id');
    }
}
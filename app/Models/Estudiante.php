<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $fillable = [
        'user_id', 'ci', 'nombre', 'apellidos', 'fecha_nacimiento',
        'email', 'telefono', 'direccion', 'colegio_procedencia',
        'anio_graduacion', 'carrera_interes_id', 'estado'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class);
    }
}
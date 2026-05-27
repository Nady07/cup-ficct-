<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
    'user_id', 'ci', 'nombre', 'apellidos', 'fecha_nacimiento', 'sexo',
    'email', 'telefono', 'direccion', 'ciudad', 'colegio_procedencia',
    'anio_graduacion', 'carrera_interes_id', 'carrera_opcion2_id', 'estado'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Usuario asociado
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Carrera de interés
    public function carreraInteres()
    {
        return $this->belongsTo(Carrera::class, 'carrera_interes_id');
    }

    // Inscripción al CUP
    public function inscripcion()
    {
        return $this->hasOne(Inscripcion::class);
    }

    // Calificaciones
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    // Obtener promedio
    public function promedio()
    {
        return $this->calificaciones()->avg('promedio') ?? 0;
    }

    // Materias aprobadas
    public function materiasAprobadas()
    {
        return $this->calificaciones()->where('estado', 'aprobado')->count();
    }

    // Materias reprobadas
    public function materiasReprobadas()
    {
        return $this->calificaciones()->where('estado', 'reprobado')->count();
    }

    // ¿Aprobó el CUP?
    public function aproboCUP()
    {
        return $this->materiasAprobadas() === 4; // Las 4 materias
    }

    // Nombre completo
    public function nombreCompleto()
    {
        return $this->apellidos . ' ' . $this->nombre;
    }
}
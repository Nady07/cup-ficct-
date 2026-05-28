<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
    'user_id', 'ci', 'nombre', 'apellidos', 'fecha_nacimiento', 'sexo',
    'email', 'telefono', 'direccion', 'ciudad', 'colegio_procedencia',
    'anio_graduacion', 'carrera_interes_id', 'carrera_opcion2_id', 'estado',
    'estado_flujo', 'requisitos_completos', 'fecha_aprobacion_requisitos',
    'fecha_pago', 'comprobante_pago_path',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_aprobacion_requisitos' => 'datetime', 
        'fecha_pago' => 'datetime',                   
        'requisitos_completos' => 'boolean',  
    ];
     // =========================================================================
    // CONSTANTES DE FLUJO (AÑADIR AQUÍ)
    // =========================================================================
    const ESTADO_POSTULANTE = 'postulante';
    const ESTADO_REQUISITOS_APROBADOS = 'requisitos_aprobados';
    const ESTADO_PAGO_CONFIRMADO = 'pago_confirmado';
    const ESTADO_INSCRITO = 'inscrito';
    const ESTADO_CUP_APROBADO = 'cup_aprobado';
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
    // Añade esto a tu modelo Estudiante:

    /**
     * Segunda opción de carrera (requisito del examen).
     */
    public function carreraOpcion2()
    {
        return $this->belongsTo(Carrera::class, 'carrera_opcion2_id');
    }

    /**
     * Accesor: Nombre completo.
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->apellidos . ' ' . $this->nombre;
    }
    // En Estudiante.php
    public function requisitosEnviados()
    {
        return $this->hasMany(EstudianteRequisito::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'estudiante_id', 'materia_id', 'nota1', 'nota2', 'nota3',
        'promedio', 'estado', 'registrado_por'
    ];

    // Calcular promedio automáticamente
    public function calcularPromedio()
    {
        $promedio = ($this->nota1 + $this->nota2 + $this->nota3) / 3;
        $this->promedio = round($promedio, 2);
        return $this->promedio;
    }

    // Determinar estado según promedio
    public function determinarEstado()
    {
        $materia = MateriaCup::find($this->materia_id);
        $notaMinima = $materia->nota_minima ?? 60;
        
        $this->estado = $this->promedio >= $notaMinima ? 'aprobado' : 'reprobado';
        return $this->estado;
    }

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia()
    {
        return $this->belongsTo(MateriaCup::class, 'materia_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
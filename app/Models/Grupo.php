<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = [
        'codigo', 'turno', 'horario_inicio', 'horario_fin',
        'capacidad_maxima', 'estudiantes_inscritos', 'docente_id', 'estado'
    ];

    // Relación con Docente
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    // Relación con Inscripciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    // Verificar si tiene cupo
    public function tieneCupo()
    {
        return $this->estudiantes_inscritos < $this->capacidad_maxima;
    }

    // Calcular cuántos grupos se necesitan según inscritos
public static function calcularGruposNecesarios()
{
    $totalInscritos = Inscripcion::where('estado', 'confirmado')->count();
    $capacidadMaxima = 70;
    
    if ($totalInscritos === 0) {
        return 0;
    }
    
    return (int) ceil($totalInscritos / $capacidadMaxima);
}

// Calcular grupos actuales vs necesarios
public static function resumenGrupos()
{
    $gruposActuales = self::count();
    $gruposNecesarios = self::calcularGruposNecesarios();
    $totalInscritos = Inscripcion::where('estado', 'confirmado')->count();
    $capacidadTotal = $gruposActuales * 70;
    $cuposDisponibles = $capacidadTotal - $totalInscritos;
    
    return [
        'total_inscritos' => $totalInscritos,
        'grupos_actuales' => $gruposActuales,
        'grupos_necesarios' => $gruposNecesarios,
        'capacidad_total' => $capacidadTotal,
        'cupos_disponibles' => max($cuposDisponibles, 0),
        'faltan_grupos' => max($gruposNecesarios - $gruposActuales, 0),
        'sobran_grupos' => max($gruposActuales - $gruposNecesarios, 0),
    ];
}
}
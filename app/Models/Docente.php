<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    protected $fillable = [
    'user_id', 'ci', 'nombre', 'apellidos', 'email', 'telefono',
    'especialidad', 'experiencia', 'curriculum_path', 'estado',
    'estado_postulacion', 'motivo_rechazo', 'fecha_postulacion', 
    'fecha_revision', 'revisado_por'
];

protected $casts = [
    'fecha_postulacion' => 'datetime',
    'fecha_revision' => 'datetime',
];

// Verificar si el docente cumple todos los requisitos obligatorios
public function cumpleRequisitosObligatorios()
{
    $requisitosObligatorios = RequisitoCup::where('tipo', 'docente')
        ->where('obligatorio', true)
        ->where('estado', true)
        ->pluck('id');
    
    $presentados = $this->requisitosPresentados()
        ->where('presentado', true)
        ->whereIn('requisito_id', $requisitosObligatorios)
        ->count();
    
    return $presentados === $requisitosObligatorios->count();
}

// Revisar postulación
public function revisarPostulacion($aprobado, $motivo = null, $revisadoPor = null)
{
    $this->update([
        'estado_postulacion' => $aprobado ? 'aprobado' : 'rechazado',
        'motivo_rechazo' => $aprobado ? null : $motivo,
        'fecha_revision' => now(),
        'revisado_por' => $revisadoPor ?? auth()->id(),
        'estado' => $aprobado,
    ]);
}

// Scope para postulantes
public function scopePostulantes($query)
{
    return $query->whereNotNull('fecha_postulacion');
}

// Scope para aprobados
public function scopeAprobados($query)
{
    return $query->where('estado_postulacion', 'aprobado');
}

// Scope para pendientes de revisión
public function scopePendientesRevision($query)
{
    return $query->where('estado_postulacion', 'pendiente')
                 ->orWhere('estado_postulacion', 'en_revision');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }
       public function nombreCompleto()
    {
        return $this->apellidos . ' ' . $this->nombre;
    }
    public function requisitosPresentados()
    {
        return $this->hasMany(DocenteRequisito::class);
    }
}
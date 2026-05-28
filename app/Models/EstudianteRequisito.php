<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstudianteRequisito extends Model
{
    protected $fillable = [
        'estudiante_id', 'requisito_id', 'archivo_path',
        'presentado', 'aprobado', 'observacion_admin',
        'fecha_presentacion', 'fecha_revision'
    ];

    protected $casts = [
        'presentado' => 'boolean',
        'aprobado' => 'boolean',
        'fecha_presentacion' => 'datetime',
        'fecha_revision' => 'datetime',
    ];

    public function estudiante() { return $this->belongsTo(Estudiante::class); }
    public function requisito() { return $this->belongsTo(RequisitoCup::class); }
}
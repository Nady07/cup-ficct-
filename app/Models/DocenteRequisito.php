<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocenteRequisito extends Model
{
    protected $table = 'docente_requisitos';

    protected $fillable = [
        'docente_id', 'requisito_id', 'presentado', 
        'fecha_presentacion', 'archivo_path', 'observacion'
    ];

    protected $casts = [
        'presentado' => 'boolean',
        'fecha_presentacion' => 'date',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function requisito()
    {
        return $this->belongsTo(RequisitoCup::class, 'requisito_id');
    }
}
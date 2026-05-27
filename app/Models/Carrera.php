<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'nombre', 'codigo', 'descripcion', 'duracion', 'titulo_otorgado', 'estado'
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'carrera_interes_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionPago extends Model
{
    protected $table = 'configuracion_pagos';
    
    protected $fillable = [
        'precio_nacional', 'precio_extranjero', 'qr_path',
        'banco', 'cuenta', 'instrucciones', 'activo'
    ];
    
    protected $casts = [
        'precio_nacional' => 'decimal:2',
        'precio_extranjero' => 'decimal:2',
        'activo' => 'boolean',
    ];
    
    public static function getActiva()
    {
        return self::where('activo', true)->first();
    }
}
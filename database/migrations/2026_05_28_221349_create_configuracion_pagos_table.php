<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio_nacional', 10, 2)->default(200.00);
            $table->decimal('precio_extranjero', 10, 2)->default(400.00);
            $table->string('qr_path')->nullable();
            $table->string('banco')->nullable();
            $table->string('cuenta')->nullable();
            $table->text('instrucciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar configuración por defecto
        DB::table('configuracion_pagos')->insert([
            'precio_nacional' => 200.00,
            'precio_extranjero' => 400.00,
            'banco' => 'Banco Unión',
            'cuenta' => '1000000000',
            'instrucciones' => 'Realiza el pago en cualquier sucursal del Banco Unión.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_pagos');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->date('fecha_inscripcion');
            $table->enum('estado', ['pendiente', 'confirmado', 'rechazado', 'completado'])->default('pendiente');
            $table->string('comprobante_pago')->nullable();
            $table->decimal('monto_pagado', 10, 2)->nullable();
            $table->string('numero_boleta', 50)->nullable();
            $table->boolean('requisitos_completos')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
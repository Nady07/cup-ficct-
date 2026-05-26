<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ci', 20)->unique();
            $table->string('nombre');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('colegio_procedencia')->nullable();
            $table->integer('anio_graduacion')->nullable();
            $table->foreignId('carrera_interes_id')->nullable()->constrained('carreras')->onDelete('set null');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar la tabla actual
        Schema::dropIfExists('calificaciones');
        
        // Crear nueva tabla con 3 notas
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias_cup')->onDelete('cascade');
            $table->decimal('nota1', 5, 2)->default(0);
            $table->decimal('nota2', 5, 2)->default(0);
            $table->decimal('nota3', 5, 2)->default(0);
            $table->decimal('promedio', 5, 2)->default(0);
            $table->enum('estado', ['aprobado', 'reprobado', 'pendiente'])->default('pendiente');
            $table->foreignId('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
        
        // Restaurar tabla original
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias_cup')->onDelete('cascade');
            $table->decimal('nota', 5, 2);
            $table->enum('estado', ['aprobado', 'reprobado']);
            $table->foreignId('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }
};
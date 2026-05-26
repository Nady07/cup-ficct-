<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->enum('turno', ['M', 'T', 'N']);
            $table->time('horario_inicio');
            $table->time('horario_fin');
            $table->integer('capacidad_maxima')->default(60);
            $table->integer('estudiantes_inscritos')->default(0);
            $table->foreignId('docente_id')->nullable()->constrained('docentes')->onDelete('set null');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docente_requisitos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('requisito_id')->constrained('requisitos_cup')->onDelete('cascade');
            $table->boolean('presentado')->default(false);
            $table->date('fecha_presentacion')->nullable();
            $table->string('archivo_path')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
            
            $table->unique(['docente_id', 'requisito_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente_requisitos');
    }
};
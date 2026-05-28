<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('estudiante_requisitos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
        $table->foreignId('requisito_id')->constrained('requisitos_cup')->cascadeOnDelete();
        $table->string('archivo_path')->nullable();
        $table->boolean('presentado')->default(false);
        $table->boolean('aprobado')->default(false);
        $table->text('observacion_admin')->nullable();
        $table->timestamp('fecha_presentacion')->nullable();
        $table->timestamp('fecha_revision')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_requisitos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias_cup', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo', 20)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('nota_minima', 5, 2)->default(60.00);
            $table->decimal('valor_puntaje', 5, 2);
            $table->integer('orden');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias_cup');
    }
};
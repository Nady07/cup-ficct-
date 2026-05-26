<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ci', 20)->unique();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('especialidad')->nullable();
            $table->text('experiencia')->nullable();
            $table->string('curriculum_path')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
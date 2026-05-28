<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            if (!Schema::hasColumn('estudiantes', 'modalidad')) {
                $table->string('modalidad')->default('presencial')->after('carrera_opcion2_id');
            }
            if (!Schema::hasColumn('estudiantes', 'es_extranjero')) {
                $table->boolean('es_extranjero')->default(false)->after('modalidad');
            }
            if (!Schema::hasColumn('estudiantes', 'documento_extranjero')) {
                $table->string('documento_extranjero')->nullable()->after('es_extranjero');
            }
            if (!Schema::hasColumn('estudiantes', 'sexo')) {
                $table->string('sexo')->nullable()->after('fecha_nacimiento');
            }
            if (!Schema::hasColumn('estudiantes', 'ciudad')) {
                $table->string('ciudad')->nullable()->after('direccion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn(['modalidad', 'es_extranjero', 'documento_extranjero', 'sexo', 'ciudad']);
        });
    }
};
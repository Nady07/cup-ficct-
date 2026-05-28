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
    Schema::table('estudiantes', function (Blueprint $table) {
        $table->string('modalidad')->default('presencial')->after('carrera_opcion2_id');
        $table->boolean('es_extranjero')->default(false)->after('modalidad');
        $table->string('documento_extranjero')->nullable()->after('es_extranjero');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            //
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->enum('estado_postulacion', ['pendiente', 'en_revision', 'aprobado', 'rechazado'])
                  ->default('pendiente')
                  ->after('estado');
            $table->text('motivo_rechazo')->nullable()->after('estado_postulacion');
            $table->timestamp('fecha_postulacion')->nullable()->after('motivo_rechazo');
            $table->timestamp('fecha_revision')->nullable()->after('fecha_postulacion');
            $table->foreignId('revisado_por')->nullable()->after('fecha_revision')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropForeign(['revisado_por']);
            $table->dropColumn(['estado_postulacion', 'motivo_rechazo', 'fecha_postulacion', 'fecha_revision', 'revisado_por']);
        });
    }
};
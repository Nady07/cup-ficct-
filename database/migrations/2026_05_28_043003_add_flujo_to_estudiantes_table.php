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
            $table->string('estado_flujo')->default('postulante'); // postulante, requisitos_aprobados, pago_confirmado, inscrito, cup_aprobado
            $table->boolean('requisitos_completos')->default(false);
            $table->dateTime('fecha_aprobacion_requisitos')->nullable();
            $table->dateTime('fecha_pago')->nullable();
            $table->string('comprobante_pago_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn(['estado_flujo', 'requisitos_completos', 'fecha_aprobacion_requisitos', 'fecha_pago', 'comprobante_pago_path']);
        });
    }
};

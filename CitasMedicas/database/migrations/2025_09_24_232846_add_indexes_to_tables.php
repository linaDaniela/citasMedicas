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
        // Índices para optimización de consultas
        Schema::table('pacientes', function (Blueprint $table) {
            $table->index('cedula', 'idx_pacientes_cedula');
            $table->index('eps_id', 'idx_pacientes_eps');
        });

        Schema::table('medicos', function (Blueprint $table) {
            $table->index('cedula', 'idx_medicos_cedula');
            $table->index('especialidad_id', 'idx_medicos_especialidad');
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->index('fecha_cita', 'idx_citas_fecha');
            $table->index('paciente_id', 'idx_citas_paciente');
            $table->index('medico_id', 'idx_citas_medico');
            $table->index('estado', 'idx_citas_estado');
        });

        Schema::table('historial_medico', function (Blueprint $table) {
            $table->index('paciente_id', 'idx_historial_paciente');
            $table->index('fecha_consulta', 'idx_historial_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropIndex('idx_pacientes_cedula');
            $table->dropIndex('idx_pacientes_eps');
        });

        Schema::table('medicos', function (Blueprint $table) {
            $table->dropIndex('idx_medicos_cedula');
            $table->dropIndex('idx_medicos_especialidad');
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->dropIndex('idx_citas_fecha');
            $table->dropIndex('idx_citas_paciente');
            $table->dropIndex('idx_citas_medico');
            $table->dropIndex('idx_citas_estado');
        });

        Schema::table('historial_medico', function (Blueprint $table) {
            $table->dropIndex('idx_historial_paciente');
            $table->dropIndex('idx_historial_fecha');
        });
    }
};
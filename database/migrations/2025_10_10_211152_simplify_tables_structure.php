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
        // Eliminar campos innecesarios de especialidades
        Schema::table('especialidades', function (Blueprint $table) {
            $table->dropColumn(['descripcion']);
        });

        // Eliminar campos innecesarios de pacientes
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'numero_documento', 'direccion', 'eps_id', 'activo']);
        });

        // Eliminar campos innecesarios de médicos
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropColumn(['activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar campos de especialidades
        Schema::table('especialidades', function (Blueprint $table) {
            $table->text('descripcion')->nullable();
        });

        // Restaurar campos de pacientes
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('direccion');
            $table->foreignId('eps_id')->nullable()->constrained();
            $table->boolean('activo')->default(true);
        });

        // Restaurar campos de médicos
        Schema::table('medicos', function (Blueprint $table) {
            $table->boolean('activo')->default(true);
        });
    }
};

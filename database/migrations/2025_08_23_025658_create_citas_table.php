<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->unsignedBigInteger('consultorio_id')->nullable();
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->integer('duracion_minutos')->default(30);
            $table->text('motivo');
            $table->enum('estado', ['Programada', 'Completada', 'Cancelada', 'No Asistió'])->default('Programada');
            $table->text('observaciones')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->date('proxima_cita')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('cedula', 20)->unique();
            $table->foreignId('especialidad_id')->nullable()->constrained('especialidades')->onDelete('set null');
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('direccion')->nullable();
            $table->integer('experiencia_anos')->default(0);
            $table->unsignedBigInteger('consultorio_id')->nullable();
            $table->time('horario_inicio')->nullable();
            $table->time('horario_fin')->nullable();
            $table->set('dias_trabajo', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'])->nullable();
            $table->decimal('tarifa_consulta', 10, 2)->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'vacaciones'])->default('activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};

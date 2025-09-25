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
        Schema::create('eps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('nit', 20)->unique();
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('sitio_web', 200)->nullable();
            $table->string('representante_legal', 150)->nullable();
            $table->string('telefono_representante', 20)->nullable();
            $table->string('email_representante', 150)->nullable();
            $table->enum('tipo_eps', ['Contributiva', 'Subsidiada', 'Mixta']);
            $table->enum('estado', ['Activa', 'Inactiva', 'Suspendida', 'En Proceso'])->default('Activa');
            $table->date('fecha_afiliacion')->nullable();
            $table->integer('total_afiliados')->default(0);
            $table->integer('total_medicos')->default(0);
            $table->integer('total_consultorios')->default(0);
            $table->decimal('calificacion', 2, 1)->default(0.0);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eps');
    }
};

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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('principio_activo', 200)->nullable();
            $table->string('laboratorio', 150)->nullable();
            $table->string('presentacion', 100)->nullable();
            $table->string('dosis', 50)->nullable();
            $table->text('indicaciones')->nullable();
            $table->text('contraindicaciones')->nullable();
            $table->text('efectos_secundarios')->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->enum('estado', ['disponible', 'agotado', 'descontinuado'])->default('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
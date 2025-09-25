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
        Schema::create('detalle_recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receta_id')->constrained('recetas_medicas')->onDelete('cascade');
            $table->foreignId('medicamento_id')->constrained('medicamentos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->string('dosis', 100)->nullable();
            $table->string('frecuencia', 100)->nullable();
            $table->string('duracion', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_recetas');
    }
};
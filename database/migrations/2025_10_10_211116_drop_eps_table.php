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
        Schema::dropIfExists('eps');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('eps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nit');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
};

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
        Schema::dropIfExists('consultorios');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('consultorios', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('piso');
            $table->string('edificio');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }
};

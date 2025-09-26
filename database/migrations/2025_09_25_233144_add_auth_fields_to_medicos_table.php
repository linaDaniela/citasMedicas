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
        Schema::table('medicos', function (Blueprint $table) {
            $table->string('usuario', 50)->unique()->after('email');
            $table->string('password')->after('usuario');
            $table->enum('estado_auth', ['activo', 'inactivo'])->default('activo')->after('password');
            $table->timestamp('email_verified_at')->nullable()->after('estado_auth');
            $table->rememberToken()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropColumn(['usuario', 'password', 'estado_auth', 'email_verified_at', 'remember_token']);
        });
    }
};

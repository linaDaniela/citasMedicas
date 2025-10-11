<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $this->call(AdminUserSeeder::class);
        
        // Crear administradores de prueba
        $this->call(AdministradorSeeder::class);
        
        // Crear pacientes de prueba
        $this->call(PacienteSeeder::class);
        
        // Crear datos de ejemplo (especialidades, EPS, consultorios)
        $this->call(ExampleDataSeeder::class);

        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'paciente'
        ]);
    }
}

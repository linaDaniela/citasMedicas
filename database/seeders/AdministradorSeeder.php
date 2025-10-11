<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear administradores de prueba
        DB::table('administradores')->insert([
            [
                'nombre' => 'Admin',
                'apellido' => 'Principal',
                'email' => 'admin@eps.com',
                'password' => Hash::make('admin123'),
                'telefono' => '3001234567',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Administrador',
                'email' => 'carlos.admin@eps.com',
                'password' => Hash::make('carlos123'),
                'telefono' => '3007654321',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Administradores de prueba creados exitosamente');
    }
}

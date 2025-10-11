<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear paciente de prueba
        DB::table('pacientes')->insert([
            'nombre' => 'Andres',
            'apellido' => 'Saavedra',
            'email' => 'andres@gmail.com',
            'password' => Hash::make('andres123'),
            'telefono' => '322659464',
            'fecha_nacimiento' => '2006-11-29',
            'tipo_documento' => 'CC',
            'numero_documento' => '1058274729',
            'direccion' => 'Belen',
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear más pacientes de prueba
        $pacientes = [
            [
                'nombre' => 'María',
                'apellido' => 'García',
                'email' => 'maria@test.com',
                'password' => Hash::make('password'),
                'telefono' => '3001234567',
                'fecha_nacimiento' => '1990-05-15',
                'tipo_documento' => 'CC',
                'numero_documento' => '12345678',
                'direccion' => 'Calle 123 #45-67',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'López',
                'email' => 'carlos@test.com',
                'password' => Hash::make('password'),
                'telefono' => '3007654321',
                'fecha_nacimiento' => '1985-12-03',
                'tipo_documento' => 'CC',
                'numero_documento' => '87654321',
                'direccion' => 'Carrera 50 #26-20',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($pacientes as $paciente) {
            DB::table('pacientes')->insert($paciente);
        }

        $this->command->info('Pacientes de prueba creados exitosamente');
        $this->command->info('Credenciales:');
        $this->command->info('- andres@gmail.com / andres123');
        $this->command->info('- maria@test.com / password');
        $this->command->info('- carlos@test.com / password');
    }
}

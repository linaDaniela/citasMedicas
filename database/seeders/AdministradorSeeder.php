<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrador::create([
            'nombre' => 'Super',
            'apellido' => 'Administrador',
            'email' => 'admin@sistema.com',
            'telefono' => '(601) 123-0000',
            'usuario' => 'admin',
            'password' => Hash::make('admin123'),
            'estado' => 'activo',
        ]);

        Administrador::create([
            'nombre' => 'María',
            'apellido' => 'González',
            'email' => 'maria.gonzalez@sistema.com',
            'telefono' => '(601) 123-0001',
            'usuario' => 'mgonzalez',
            'password' => Hash::make('admin123'),
            'estado' => 'activo',
        ]);
    }
}

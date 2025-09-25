<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'email' => 'admin@eps.com',
                'telefono' => '(601) 123-0000',
                'usuario' => 'admin',
                'password' => Hash::make('password'),
                'rol' => 'admin',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'email' => 'maria.gonzalez@eps.com',
                'telefono' => '(601) 123-0001',
                'usuario' => 'mgonzalez',
                'password' => Hash::make('password'),
                'rol' => 'recepcionista',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'email' => 'carlos.rodriguez@eps.com',
                'telefono' => '(601) 123-0002',
                'usuario' => 'crodriguez',
                'password' => Hash::make('password'),
                'rol' => 'medico',
                'estado' => 'activo',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
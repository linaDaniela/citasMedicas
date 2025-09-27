<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicos;
use Illuminate\Support\Facades\Hash;

class MedicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicos = [
            [
                'nombre' => 'Wylmer',
                'apellido' => 'Morales',
                'cedula' => '56781234',
                'especialidad_id' => 1, // Cardiología
                'telefono' => '(601) 123-4567',
                'email' => 'Wilmer.Morales@hospital.com',
                'direccion' => 'Calle 85 #12-34, Bogotá',
                'experiencia_anos' => 8,
                'consultorio_id' => 1,
                'horario_inicio' => '08:00:00',
                'horario_fin' => '17:00:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 150000.00,
                'estado' => 'activo',
                'usuario' => 'wmorales',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Andres',
                'apellido' => 'Saavedra',
                'cedula' => '67892345',
                'especialidad_id' => 2, // Dermatología
                'telefono' => '(601) 234-5678',
                'email' => 'andresaavedra@hospital.com',
                'direccion' => 'Carrera 45 #67-89, Bogotá',
                'experiencia_anos' => 5,
                'consultorio_id' => 3,
                'horario_inicio' => '09:00:00',
                'horario_fin' => '18:00:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 120000.00,
                'estado' => 'activo',
                'usuario' => 'asaavedra',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Juan Pablo',
                'apellido' => 'Barrera',
                'cedula' => '78903456',
                'especialidad_id' => 3, // Ortopedia
                'telefono' => '(601) 345-6789',
                'email' => 'Juan.Barrera@hospital.com',
                'direccion' => 'Avenida 80 #12-34, Bogotá',
                'experiencia_anos' => 12,
                'consultorio_id' => 4,
                'horario_inicio' => '07:30:00',
                'horario_fin' => '16:30:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 180000.00,
                'estado' => 'activo',
                'usuario' => 'jbarrera',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Valentina',
                'apellido' => 'Cepeda',
                'cedula' => '45678901',
                'especialidad_id' => 4, // Ginecología
                'telefono' => '(601) 456-7890',
                'email' => 'Valentina.cepeda@hospital.com',
                'direccion' => 'Calle 100 #56-78, Bogotá',
                'experiencia_anos' => 10,
                'consultorio_id' => 5,
                'horario_inicio' => '08:30:00',
                'horario_fin' => '17:30:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 160000.00,
                'estado' => 'activo',
                'usuario' => 'vcepeda',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Maryuri',
                'apellido' => 'Zorro',
                'cedula' => '90125678',
                'especialidad_id' => 5, // Neurología
                'telefono' => '(601) 567-8901',
                'email' => 'Maryuri.Zorro@hospital.com',
                'direccion' => 'Carrera 15 #23-45, Bogotá',
                'experiencia_anos' => 15,
                'consultorio_id' => 6,
                'horario_inicio' => '08:00:00',
                'horario_fin' => '17:00:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 200000.00,
                'estado' => 'activo',
                'usuario' => 'mzorro',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'García',
                'cedula' => '12345678',
                'especialidad_id' => 1, // Cardiología
                'telefono' => '(601) 678-9012',
                'email' => 'carlos.garcia@hospital.com',
                'direccion' => 'Calle 70 #45-67, Bogotá',
                'experiencia_anos' => 6,
                'consultorio_id' => 2,
                'horario_inicio' => '09:00:00',
                'horario_fin' => '18:00:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 140000.00,
                'estado' => 'activo',
                'usuario' => 'cgarcia',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'cedula' => '23456789',
                'especialidad_id' => 2, // Dermatología
                'telefono' => '(601) 789-0123',
                'email' => 'ana.martinez@hospital.com',
                'direccion' => 'Avenida 68 #78-90, Bogotá',
                'experiencia_anos' => 7,
                'consultorio_id' => 3,
                'horario_inicio' => '08:00:00',
                'horario_fin' => '17:00:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 130000.00,
                'estado' => 'activo',
                'usuario' => 'amartinez',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'Fernández',
                'cedula' => '34567890',
                'especialidad_id' => 3, // Ortopedia
                'telefono' => '(601) 890-1234',
                'email' => 'luis.fernandez@hospital.com',
                'direccion' => 'Carrera 50 #12-34, Bogotá',
                'experiencia_anos' => 9,
                'consultorio_id' => 4,
                'horario_inicio' => '07:00:00',
                'horario_fin' => '16:00:00',
                'dias_trabajo' => 'lunes,martes,miercoles,jueves,viernes',
                'tarifa_consulta' => 170000.00,
                'estado' => 'activo',
                'usuario' => 'lfernandez',
                'password' => Hash::make('medico123'),
                'estado_auth' => 'activo',
            ],
        ];

        foreach ($medicos as $medico) {
            Medicos::create($medico);
        }
    }
}
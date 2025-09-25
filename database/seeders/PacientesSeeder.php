<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pacientes;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pacientes = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pineda',
                'cedula' => '12345678',
                'fecha_nacimiento' => '1989-05-15',
                'telefono' => '(601) 123-4567',
                'email' => 'juan.pineda@email.com',
                'direccion' => 'Calle 123 #45-67, Bogotá',
                'eps_id' => 1, // EPS Sanitas
                'tipo_afiliacion' => 'Cotizante',
                'numero_afiliacion' => 'SAN001234567',
                'grupo_sanguineo' => 'A+',
                'alergias' => 'Penicilina',
                'medicamentos_actuales' => 'Metformina 500mg',
                'contacto_emergencia_nombre' => 'María Pineda',
                'contacto_emergencia_telefono' => '(601) 123-4568',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'María',
                'apellido' => 'Lisarazo',
                'cedula' => '23456789',
                'fecha_nacimiento' => '1996-03-22',
                'telefono' => '(601) 234-5678',
                'email' => 'maria.lisarazo@email.com',
                'direccion' => 'Carrera 45 #78-90, Medellín',
                'eps_id' => 2, // EPS Sura
                'tipo_afiliacion' => 'Beneficiario',
                'numero_afiliacion' => 'SUR002345678',
                'grupo_sanguineo' => 'B+',
                'alergias' => 'Ninguna',
                'medicamentos_actuales' => 'Anticonceptivos',
                'contacto_emergencia_nombre' => 'Carlos Lisarazo',
                'contacto_emergencia_telefono' => '(601) 234-5679',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Hugo',
                'apellido' => 'Rodríguez',
                'cedula' => '34567890',
                'fecha_nacimiento' => '1982-11-08',
                'telefono' => '(601) 345-6789',
                'email' => 'Hugo.rodriguez@email.com',
                'direccion' => 'Avenida 80 #12-34, Cali',
                'eps_id' => 3, // EPS Coomeva
                'tipo_afiliacion' => 'Cotizante',
                'numero_afiliacion' => 'COO003456789',
                'grupo_sanguineo' => 'O+',
                'alergias' => 'Aspirina',
                'medicamentos_actuales' => 'Lisinopril 10mg',
                'contacto_emergencia_nombre' => 'Laura Rodríguez',
                'contacto_emergencia_telefono' => '(601) 345-6790',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Laura',
                'apellido' => 'Cardozo',
                'cedula' => '45678901',
                'fecha_nacimiento' => '1993-07-14',
                'telefono' => '(601) 456-7890',
                'email' => 'laura.cardozo@email.com',
                'direccion' => 'Calle 100 #56-78, Barranquilla',
                'eps_id' => 4, // EPS Compensar
                'tipo_afiliacion' => 'Beneficiario',
                'numero_afiliacion' => 'COM004567890',
                'grupo_sanguineo' => 'AB+',
                'alergias' => 'Ninguna',
                'medicamentos_actuales' => 'Vitamina D',
                'contacto_emergencia_nombre' => 'Pedro Cardozo',
                'contacto_emergencia_telefono' => '(601) 456-7891',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'García',
                'cedula' => '56789012',
                'fecha_nacimiento' => '1975-12-03',
                'telefono' => '(601) 567-8901',
                'email' => 'luis.garcia@email.com',
                'direccion' => 'Carrera 30 #12-45, Bogotá',
                'eps_id' => 1, // EPS Sanitas
                'tipo_afiliacion' => 'Cotizante',
                'numero_afiliacion' => 'SAN005678901',
                'grupo_sanguineo' => 'A-',
                'alergias' => 'Ibuprofeno',
                'medicamentos_actuales' => 'Omeprazol 20mg',
                'contacto_emergencia_nombre' => 'Carmen García',
                'contacto_emergencia_telefono' => '(601) 567-8902',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Carmen',
                'apellido' => 'Ruiz',
                'cedula' => '67890123',
                'fecha_nacimiento' => '1988-09-18',
                'telefono' => '(601) 678-9012',
                'email' => 'carmen.ruiz@email.com',
                'direccion' => 'Calle 85 #67-89, Medellín',
                'eps_id' => 2, // EPS Sura
                'tipo_afiliacion' => 'Cotizante',
                'numero_afiliacion' => 'SUR006789012',
                'grupo_sanguineo' => 'B-',
                'alergias' => 'Ninguna',
                'medicamentos_actuales' => 'Acetaminofén',
                'contacto_emergencia_nombre' => 'Miguel Ruiz',
                'contacto_emergencia_telefono' => '(601) 678-9013',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Pedro',
                'apellido' => 'Sánchez',
                'cedula' => '78901234',
                'fecha_nacimiento' => '1991-04-25',
                'telefono' => '(601) 789-0123',
                'email' => 'pedro.sanchez@email.com',
                'direccion' => 'Avenida 68 #34-56, Cali',
                'eps_id' => 3, // EPS Coomeva
                'tipo_afiliacion' => 'Beneficiario',
                'numero_afiliacion' => 'COO007890123',
                'grupo_sanguineo' => 'O-',
                'alergias' => 'Penicilina',
                'medicamentos_actuales' => 'Ninguno',
                'contacto_emergencia_nombre' => 'Ana Sánchez',
                'contacto_emergencia_telefono' => '(601) 789-0124',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'López',
                'cedula' => '89012345',
                'fecha_nacimiento' => '1985-08-12',
                'telefono' => '(601) 890-1234',
                'email' => 'ana.lopez@email.com',
                'direccion' => 'Carrera 50 #89-01, Barranquilla',
                'eps_id' => 4, // EPS Compensar
                'tipo_afiliacion' => 'Cotizante',
                'numero_afiliacion' => 'COM008901234',
                'grupo_sanguineo' => 'AB-',
                'alergias' => 'Ninguna',
                'medicamentos_actuales' => 'Calcio',
                'contacto_emergencia_nombre' => 'Roberto López',
                'contacto_emergencia_telefono' => '(601) 890-1235',
                'estado' => 'activo',
            ],
        ];

        foreach ($pacientes as $paciente) {
            Pacientes::create($paciente);
        }
    }
}
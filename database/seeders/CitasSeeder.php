<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Citas;

class CitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citas = [
            [
                'paciente_id' => 1,
                'medico_id' => 1,
                'consultorio_id' => 1,
                'fecha_cita' => '2024-01-15',
                'hora_cita' => '10:00:00',
                'duracion_minutos' => 30,
                'motivo' => 'Consulta de seguimiento',
                'estado' => 'Programada',
                'observaciones' => 'Paciente con antecedentes de hipertensión',
            ],
            [
                'paciente_id' => 2,
                'medico_id' => 2,
                'consultorio_id' => 3,
                'fecha_cita' => '2024-01-16',
                'hora_cita' => '14:30:00',
                'duracion_minutos' => 30,
                'motivo' => 'Revisión de lunares',
                'estado' => 'Completada',
                'observaciones' => 'Se realizó examen completo de piel',
            ],
            [
                'paciente_id' => 3,
                'medico_id' => 3,
                'consultorio_id' => 4,
                'fecha_cita' => '2024-01-17',
                'hora_cita' => '09:15:00',
                'duracion_minutos' => 45,
                'motivo' => 'Dolor en rodilla',
                'estado' => 'Cancelada',
                'observaciones' => 'Paciente canceló por motivos personales',
            ],
            [
                'paciente_id' => 4,
                'medico_id' => 4,
                'consultorio_id' => 5,
                'fecha_cita' => '2024-01-18',
                'hora_cita' => '11:45:00',
                'duracion_minutos' => 30,
                'motivo' => 'Control anual',
                'estado' => 'Programada',
                'observaciones' => 'Control ginecológico de rutina',
            ],
            [
                'paciente_id' => 5,
                'medico_id' => 1,
                'consultorio_id' => 1,
                'fecha_cita' => '2024-01-19',
                'hora_cita' => '08:30:00',
                'duracion_minutos' => 30,
                'motivo' => 'Revisión de medicación',
                'estado' => 'Programada',
                'observaciones' => 'Paciente diabético en control',
            ],
            [
                'paciente_id' => 6,
                'medico_id' => 2,
                'consultorio_id' => 3,
                'fecha_cita' => '2024-01-20',
                'hora_cita' => '15:00:00',
                'duracion_minutos' => 30,
                'motivo' => 'Consulta por acné',
                'estado' => 'Programada',
                'observaciones' => 'Primera consulta dermatológica',
            ],
            [
                'paciente_id' => 7,
                'medico_id' => 3,
                'consultorio_id' => 4,
                'fecha_cita' => '2024-01-21',
                'hora_cita' => '10:30:00',
                'duracion_minutos' => 45,
                'motivo' => 'Lesión deportiva',
                'estado' => 'Programada',
                'observaciones' => 'Posible fractura en tobillo',
            ],
            [
                'paciente_id' => 8,
                'medico_id' => 4,
                'consultorio_id' => 5,
                'fecha_cita' => '2024-01-22',
                'hora_cita' => '09:00:00',
                'duracion_minutos' => 30,
                'motivo' => 'Consulta prenatal',
                'estado' => 'Programada',
                'observaciones' => 'Control de embarazo',
            ],
        ];

        foreach ($citas as $cita) {
            Citas::create($cita);
        }
    }
}
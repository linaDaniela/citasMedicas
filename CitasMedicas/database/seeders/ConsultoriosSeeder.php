<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Consultorios;

class ConsultoriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultorios = [
            [
                'nombre' => 'Consultorio Cardiología 1',
                'numero' => '101',
                'piso' => '1',
                'edificio' => 'Torre A',
                'direccion' => 'Hospital Central - Torre A, Piso 1',
                'telefono' => '(601) 101-1001',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'Electrocardiógrafo, Ecógrafo cardiaco',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Cardiología 2',
                'numero' => '102',
                'piso' => '1',
                'edificio' => 'Torre A',
                'direccion' => 'Hospital Central - Torre A, Piso 1',
                'telefono' => '(601) 101-1002',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'Electrocardiógrafo, Ecógrafo cardiaco',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Dermatología 1',
                'numero' => '205',
                'piso' => '2',
                'edificio' => 'Torre A',
                'direccion' => 'Hospital Central - Torre A, Piso 2',
                'telefono' => '(601) 101-2005',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'Dermatoscopio, Lámpara de Wood',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Ortopedia 1',
                'numero' => '310',
                'piso' => '3',
                'edificio' => 'Torre A',
                'direccion' => 'Hospital Central - Torre A, Piso 3',
                'telefono' => '(601) 101-3010',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'Rayos X portátil, Inmovilizadores',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Ginecología 1',
                'numero' => '415',
                'piso' => '4',
                'edificio' => 'Torre A',
                'direccion' => 'Hospital Central - Torre A, Piso 4',
                'telefono' => '(601) 101-4015',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'Ecógrafo ginecológico, Colposcopio',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Neurología 1',
                'numero' => '520',
                'piso' => '5',
                'edificio' => 'Torre A',
                'direccion' => 'Hospital Central - Torre A, Piso 5',
                'telefono' => '(601) 101-5020',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'EEG, EMG',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Pediatría 1',
                'numero' => '301',
                'piso' => '3',
                'edificio' => 'Torre B',
                'direccion' => 'Hospital Central - Torre B, Piso 3',
                'telefono' => '(601) 101-3001',
                'capacidad_pacientes' => 2,
                'equipos_medicos' => 'Balanza pediátrica, Estetoscopio pediátrico',
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Consultorio Psiquiatría 1',
                'numero' => '405',
                'piso' => '4',
                'edificio' => 'Torre B',
                'direccion' => 'Hospital Central - Torre B, Piso 4',
                'telefono' => '(601) 101-4005',
                'capacidad_pacientes' => 1,
                'equipos_medicos' => 'Sala de relajación, Test psicológicos',
                'estado' => 'disponible',
            ],
        ];

        foreach ($consultorios as $consultorio) {
            Consultorios::create($consultorio);
        }
    }
}
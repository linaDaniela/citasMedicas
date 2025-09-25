<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Especialidades;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            [
                'nombre' => 'Cardiología',
                'descripcion' => 'Especialidad médica que se encarga del corazón y sistema cardiovascular',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Dermatología',
                'descripcion' => 'Especialidad médica que se encarga de la piel y enfermedades cutáneas',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Ortopedia',
                'descripcion' => 'Especialidad médica que se encarga de huesos, articulaciones y músculos',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Ginecología',
                'descripcion' => 'Especialidad médica que se encarga de la salud femenina',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Neurología',
                'descripcion' => 'Especialidad médica que se encarga del sistema nervioso',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Pediatría',
                'descripcion' => 'Especialidad médica que se encarga de la salud infantil',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Psiquiatría',
                'descripcion' => 'Especialidad médica que se encarga de la salud mental',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Oftalmología',
                'descripcion' => 'Especialidad médica que se encarga de los ojos y visión',
                'estado' => 'activa',
            ],
        ];

        foreach ($especialidades as $especialidad) {
            Especialidades::create($especialidad);
        }
    }
}
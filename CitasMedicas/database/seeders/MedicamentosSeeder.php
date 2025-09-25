<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicamentos;

class MedicamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicamentos = [
            [
                'nombre' => 'Metformina',
                'principio_activo' => 'Metformina HCl',
                'laboratorio' => 'Genfar',
                'presentacion' => 'Tableta 500mg',
                'dosis' => '500mg',
                'indicaciones' => 'Diabetes tipo 2',
                'contraindicaciones' => 'Insuficiencia renal severa',
                'efectos_secundarios' => 'Náuseas, diarrea',
                'precio' => 25000.00,
                'stock' => 100,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Lisinopril',
                'principio_activo' => 'Lisinopril',
                'laboratorio' => 'Tecnoquímicas',
                'presentacion' => 'Tableta 10mg',
                'dosis' => '10mg',
                'indicaciones' => 'Hipertensión arterial',
                'contraindicaciones' => 'Embarazo',
                'efectos_secundarios' => 'Tos seca, mareos',
                'precio' => 18000.00,
                'stock' => 80,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Omeprazol',
                'principio_activo' => 'Omeprazol',
                'laboratorio' => 'Procaps',
                'presentacion' => 'Cápsula 20mg',
                'dosis' => '20mg',
                'indicaciones' => 'Gastritis, úlcera',
                'contraindicaciones' => 'Alergia al omeprazol',
                'efectos_secundarios' => 'Dolor de cabeza',
                'precio' => 12000.00,
                'stock' => 150,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Acetaminofén',
                'principio_activo' => 'Paracetamol',
                'laboratorio' => 'Genfar',
                'presentacion' => 'Tableta 500mg',
                'dosis' => '500mg',
                'indicaciones' => 'Dolor, fiebre',
                'contraindicaciones' => 'Insuficiencia hepática',
                'efectos_secundarios' => 'Rash cutáneo',
                'precio' => 5000.00,
                'stock' => 200,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Ibuprofeno',
                'principio_activo' => 'Ibuprofeno',
                'laboratorio' => 'Tecnoquímicas',
                'presentacion' => 'Tableta 400mg',
                'dosis' => '400mg',
                'indicaciones' => 'Dolor, inflamación',
                'contraindicaciones' => 'Úlcera gástrica',
                'efectos_secundarios' => 'Gastritis',
                'precio' => 8000.00,
                'stock' => 120,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Calcio',
                'principio_activo' => 'Carbonato de calcio',
                'laboratorio' => 'Procaps',
                'presentacion' => 'Tableta 500mg',
                'dosis' => '500mg',
                'indicaciones' => 'Osteoporosis',
                'contraindicaciones' => 'Hipercalcemia',
                'efectos_secundarios' => 'Estreñimiento',
                'precio' => 15000.00,
                'stock' => 90,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Vitamina D',
                'principio_activo' => 'Colecalciferol',
                'laboratorio' => 'Genfar',
                'presentacion' => 'Cápsula 1000 UI',
                'dosis' => '1000 UI',
                'indicaciones' => 'Deficiencia de vitamina D',
                'contraindicaciones' => 'Hipercalcemia',
                'efectos_secundarios' => 'Náuseas',
                'precio' => 20000.00,
                'stock' => 75,
                'estado' => 'disponible',
            ],
            [
                'nombre' => 'Penicilina',
                'principio_activo' => 'Penicilina G',
                'laboratorio' => 'Tecnoquímicas',
                'presentacion' => 'Inyección 1M UI',
                'dosis' => '1M UI',
                'indicaciones' => 'Infecciones bacterianas',
                'contraindicaciones' => 'Alergia a penicilina',
                'efectos_secundarios' => 'Rash, anafilaxia',
                'precio' => 35000.00,
                'stock' => 50,
                'estado' => 'disponible',
            ],
        ];

        foreach ($medicamentos as $medicamento) {
            Medicamentos::create($medicamento);
        }
    }
}
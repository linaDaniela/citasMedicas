<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Eps;

class EpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eps = [
            [
                'nombre' => 'EPS Sanitas',
                'nit' => '900123456-1',
                'direccion' => 'Calle 100 #15-20, Bogotá D.C.',
                'telefono' => '(601) 123-4567',
                'email' => 'contacto@sanitas.com',
                'sitio_web' => 'https://www.sanitas.com',
                'representante_legal' => 'Dr. Juan Carlos Pérez',
                'telefono_representante' => '(601) 987-6543',
                'email_representante' => 'jperez@sanitas.com',
                'tipo_eps' => 'Contributiva',
                'estado' => 'Activa',
                'fecha_afiliacion' => '2020-01-15',
                'total_afiliados' => 2500000,
                'total_medicos' => 15000,
                'total_consultorios' => 850,
                'calificacion' => 4.5,
                'observaciones' => 'EPS con amplia cobertura nacional y excelente atención al usuario.',
            ],
            [
                'nombre' => 'EPS Sura',
                'nit' => '900234567-2',
                'direccion' => 'Carrera 50 #25-30, Medellín',
                'telefono' => '(601) 234-5678',
                'email' => 'contacto@sura.com',
                'sitio_web' => 'https://www.sura.com',
                'representante_legal' => 'Dra. María González',
                'telefono_representante' => '(601) 876-5432',
                'email_representante' => 'mgonzalez@sura.com',
                'tipo_eps' => 'Contributiva',
                'estado' => 'Activa',
                'fecha_afiliacion' => '2019-03-20',
                'total_afiliados' => 3200000,
                'total_medicos' => 18000,
                'total_consultorios' => 1200,
                'calificacion' => 4.3,
                'observaciones' => 'EPS líder en innovación tecnológica y atención personalizada.',
            ],
            [
                'nombre' => 'EPS Coomeva',
                'nit' => '900345678-3',
                'direccion' => 'Avenida 68 #25-47, Cali',
                'telefono' => '(601) 345-6789',
                'email' => 'contacto@coomeva.com',
                'sitio_web' => 'https://www.coomeva.com',
                'representante_legal' => 'Dr. Carlos Rodríguez',
                'telefono_representante' => '(601) 765-4321',
                'email_representante' => 'crodriguez@coomeva.com',
                'tipo_eps' => 'Mixta',
                'estado' => 'Activa',
                'fecha_afiliacion' => '2021-06-10',
                'total_afiliados' => 1800000,
                'total_medicos' => 12000,
                'total_consultorios' => 650,
                'calificacion' => 4.1,
                'observaciones' => 'EPS cooperativa con enfoque en medicina preventiva.',
            ],
            [
                'nombre' => 'EPS Compensar',
                'nit' => '900456789-4',
                'direccion' => 'Calle 80 #10-15, Bogotá D.C.',
                'telefono' => '(601) 456-7890',
                'email' => 'contacto@compensar.com',
                'sitio_web' => 'https://www.compensar.com',
                'representante_legal' => 'Dra. Ana Martínez',
                'telefono_representante' => '(601) 654-3210',
                'email_representante' => 'amartinez@compensar.com',
                'tipo_eps' => 'Contributiva',
                'estado' => 'Activa',
                'fecha_afiliacion' => '2018-11-25',
                'total_afiliados' => 2200000,
                'total_medicos' => 14000,
                'total_consultorios' => 750,
                'calificacion' => 4.2,
                'observaciones' => 'EPS con fuerte presencia en la región central del país.',
            ],
            [
                'nombre' => 'EPS Famisanar',
                'nit' => '900567890-5',
                'direccion' => 'Carrera 7 #32-16, Bogotá D.C.',
                'telefono' => '(601) 567-8901',
                'email' => 'contacto@famisanar.com',
                'sitio_web' => 'https://www.famisanar.com',
                'representante_legal' => 'Dr. Luis Fernández',
                'telefono_representante' => '(601) 543-2109',
                'email_representante' => 'lfernandez@famisanar.com',
                'tipo_eps' => 'Subsidiada',
                'estado' => 'Activa',
                'fecha_afiliacion' => '2020-08-12',
                'total_afiliados' => 1500000,
                'total_medicos' => 9000,
                'total_consultorios' => 500,
                'calificacion' => 3.9,
                'observaciones' => 'EPS especializada en atención a población vulnerable.',
            ],
        ];

        foreach ($eps as $epsData) {
            Eps::create($epsData);
        }
    }
}
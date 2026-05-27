<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CUPSeeder extends Seeder
{
    public function run(): void
    {
        // CARRERAS FICCT
        DB::table('carreras')->insert([
            [
                'nombre' => 'Ingeniería Informática',
                'codigo' => 'INF',
                'descripcion' => 'Desarrollo de software, bases de datos y sistemas de información',
                'duracion' => '5 años',
                'titulo_otorgado' => 'Ingeniero Informático',
                'estado' => true,
            ],
            [
                'nombre' => 'Ingeniería en Sistemas',
                'codigo' => 'SIS',
                'descripcion' => 'Diseño, implementación y gestión de sistemas informáticos',
                'duracion' => '5 años',
                'titulo_otorgado' => 'Ingeniero en Sistemas',
                'estado' => true,
            ],
            [
                'nombre' => 'Ingeniería en Redes y Telecomunicaciones',
                'codigo' => 'RED',
                'descripcion' => 'Infraestructura de redes, comunicaciones y seguridad',
                'duracion' => '5 años',
                'titulo_otorgado' => 'Ingeniero en Redes y Telecomunicaciones',
                'estado' => true,
            ],
            [
                'nombre' => 'Ingeniería en Robótica',
                'codigo' => 'ROB',
                'descripcion' => 'Diseño y programación de sistemas robóticos',
                'duracion' => '5 años',
                'titulo_otorgado' => 'Ingeniero en Robótica',
                'estado' => true,
            ],
        ]);

        // MATERIAS DEL CUP
        DB::table('materias_cup')->insert([
            [
                'nombre' => 'Matemáticas',
                'codigo' => 'CUP-MAT',
                'descripcion' => 'Álgebra, trigonometría, geometría analítica',
                'nota_minima' => 60.00,
                'valor_puntaje' => 25.00,
                'orden' => 1,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Física',
                'codigo' => 'CUP-FIS',
                'descripcion' => 'Mecánica, electricidad, magnetismo',
                'nota_minima' => 60.00,
                'valor_puntaje' => 25.00,
                'orden' => 2,
                'estado' => true,
            ],
            [
                'nombre' => 'Química',
                'codigo' => 'CUP-QUI',
                'descripcion' => 'Química general, estequiometría, soluciones',
                'nota_minima' => 60.00,
                'valor_puntaje' => 25.00,
                'orden' => 3,
                'estado' => true,
            ],
            [
                'nombre' => 'Programación Básica',
                'codigo' => 'CUP-PRG',
                'descripcion' => 'Fundamentos de programación, algoritmos, pseudocódigo',
                'nota_minima' => 60.00,
                'valor_puntaje' => 25.00,
                'orden' => 4,
                'estado' => true,
            ],
        ]);

        // GRUPOS (12 grupos: 4 por turno)
        $turnos = [
            'M' => ['07:30', '11:30'],
            'T' => ['13:30', '17:30'],
            'N' => ['18:30', '21:50'],
        ];

        foreach ($turnos as $turno => $horario) {
            for ($i = 1; $i <= 4; $i++) {
                DB::table('grupos')->insert([
                    'codigo' => $turno . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'turno' => $turno,
                    'horario_inicio' => $horario[0],
                    'horario_fin' => $horario[1],
                    'capacidad_maxima' => 60,
                    'estudiantes_inscritos' => 0,
                    'estado' => true,
                ]);
            }
        }

        // REQUISITOS
        DB::table('requisitos_cup')->insert([
            // Estudiantes
            ['descripcion' => 'Fotocopia de carnet de identidad vigente', 'tipo' => 'estudiante', 'obligatorio' => true],
            ['descripcion' => 'Certificado de nacimiento original', 'tipo' => 'estudiante', 'obligatorio' => true],
            ['descripcion' => 'Título de bachiller (fotocopia legalizada)', 'tipo' => 'estudiante', 'obligatorio' => true],
            ['descripcion' => '4 fotografías 4x4 fondo rojo', 'tipo' => 'estudiante', 'obligatorio' => true],
            ['descripcion' => 'Formulario de inscripción completado', 'tipo' => 'estudiante', 'obligatorio' => true],
            ['descripcion' => 'Comprobante de pago del CUP', 'tipo' => 'estudiante', 'obligatorio' => true],
            // Docentes
            ['descripcion' => 'Hoja de vida actualizada', 'tipo' => 'docente', 'obligatorio' => true],
            ['descripcion' => 'Título profesional en el área', 'tipo' => 'docente', 'obligatorio' => true],
            ['descripcion' => 'Experiencia docente mínima 2 años', 'tipo' => 'docente', 'obligatorio' => true],
            ['descripcion' => 'Certificado de antecedentes penales', 'tipo' => 'docente', 'obligatorio' => true],
        ]);

        // CONFIGURACIONES
        DB::table('configuraciones')->insert([
            ['clave' => 'monto_inscripcion', 'valor' => '350.00', 'descripcion' => 'Monto de inscripción CUP I/2025'],
            ['clave' => 'gestion', 'valor' => 'I/2025', 'descripcion' => 'Gestión actual'],
        ]);
    }
}
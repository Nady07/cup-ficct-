<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\MateriaCup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Muestra el panel administrativo principal con todos los indicadores
     * requeridos en el examen:
     * - Total inscritos
     * - Total aprobados / reprobados
     * - Total grupos habilitados (CEIL(inscritos/80))
     * - Estadísticas por materia
     * - Grupos con mayor cantidad de aprobados
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cache de estadísticas principales (10 minutos)
        $stats = Cache::remember('dashboard_stats', 600, function () {
            
            // Totales básicos
            $totalInscritos = Estudiante::count();
            $totalGrupos = Grupo::count();
            $totalDocentes = Docente::count();
            $totalCarreras = Carrera::where('estado', true)->count();
            
            // Cálculo de grupos habilitados según fórmula del examen: CEIL(inscritos/80)
            $gruposHabilitados = (int) ceil($totalInscritos / 80);
            
            // Estadísticas de calificaciones (aprobados/reprobados)
            $aprobados = Calificacion::where('estado', 'aprobado')
                ->distinct('estudiante_id')
                ->count('estudiante_id');
                
            $reprobados = Calificacion::where('estado', 'reprobado')
                ->distinct('estudiante_id')
                ->count('estudiante_id');
            
            // Inscripciones
            $inscripcionesPendientes = Inscripcion::where('estado', 'pendiente')->count();
            $inscripcionesConfirmadas = Inscripcion::where('estado', 'confirmado')->count();
            
            // Materias activas
            $materiasActivas = MateriaCup::where('estado', true)->count();
            
            // Grupos disponibles vs llenos (usando el método de tu modelo)
            $gruposDisponibles = Grupo::whereColumn('estudiantes_inscritos', '<', 'capacidad_maxima')->count();
            $gruposLlenos = Grupo::whereColumn('estudiantes_inscritos', '>=', 'capacidad_maxima')->count();
            
            // Promedio general de calificaciones
            $promedioGeneral = Calificacion::avg('promedio') ?? 0;
            
            return [
                'total_inscritos'            => $totalInscritos,
                'total_grupos'               => $totalGrupos,
                'grupos_habilitados'         => $gruposHabilitados, // Fórmula del examen
                'total_docentes'             => $totalDocentes,
                'total_carreras'             => $totalCarreras,
                'total_aprobados'            => $aprobados,
                'total_reprobados'           => $reprobados,
                'inscripciones_pendientes'   => $inscripcionesPendientes,
                'inscripciones_confirmadas'  => $inscripcionesConfirmadas,
                'materias_activas'           => $materiasActivas,
                'grupos_disponibles'         => $gruposDisponibles,
                'grupos_llenos'              => $gruposLlenos,
                'promedio_general'           => round($promedioGeneral, 2),
                'porcentaje_aprobados'       => $totalInscritos > 0 
                    ? round(($aprobados / $totalInscritos) * 100, 1) 
                    : 0,
            ];
        });

        // Estadísticas por materia (cache 5 minutos)
        $estadisticasPorMateria = Cache::remember('dashboard_materias_stats', 300, function () {
            return MateriaCup::where('estado', true)
                ->withCount(['calificaciones', 
                    'calificaciones as aprobados_count' => function ($query) {
                        $query->where('estado', 'aprobado');
                    },
                    'calificaciones as reprobados_count' => function ($query) {
                        $query->where('estado', 'reprobado');
                    }
                ])
                ->get()
                ->map(function ($materia) {
                    $total = $materia->calificaciones_count;
                    $materia->porcentaje_aprobados = $total > 0 
                        ? round(($materia->aprobados_count / $total) * 100, 1) 
                        : 0;
                    $materia->promedio_materia = $total > 0 
                        ? round($materia->calificaciones()->avg('promedio'), 2) 
                        : 0;
                    return $materia;
                });
        });

        // Grupos con mayor cantidad de aprobados (Top 5)
        // ADAPTADO a tu modelo Grupo (sin relación directa con materia)
        $gruposDestacados = Cache::remember('dashboard_grupos_top', 300, function () {
            return Grupo::with(['docente'])
                ->withCount(['inscripciones as aprobados_count' => function ($query) {
                    $query->whereHas('estudiante.calificaciones', function ($q) {
                        $q->where('estado', 'aprobado');
                    });
                }])
                ->orderByDesc('aprobados_count')
                ->take(5)
                ->get();
        });

        // Últimas inscripciones con eager loading
        // ADAPTADO a tu modelo: quitado 'grupo.materia' porque no existe esa relación
        $ultimasInscripciones = Inscripcion::with([
                'estudiante.carrera', 
                'grupo.docente',  // Solo docente, la materia se obtiene de otra forma
            ])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'estadisticasPorMateria',
            'gruposDestacados',
            'ultimasInscripciones'
        ));
    }
}
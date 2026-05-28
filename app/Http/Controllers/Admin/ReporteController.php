<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\MateriaCup;
use App\Models\Inscripcion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    // 1. Lista general de postulantes
    public function postulantes()
    {
        $estudiantes = Estudiante::with(['carreraInteres', 'inscripcion.grupo'])
            ->orderBy('apellidos')
            ->paginate(20);
        
        return view('admin.reportes.postulantes', compact('estudiantes'));
    }

    // 2. Postulantes aprobados
    public function aprobados()
    {
        $aprobados = Estudiante::whereHas('calificaciones', function($q) {
                $q->where('estado', 'aprobado');
            }, '=', 4) // Las 4 materias aprobadas
            ->with(['calificaciones.materia', 'inscripcion.grupo'])
            ->orderBy('apellidos')
            ->paginate(20);
        
        return view('admin.reportes.aprobados', compact('aprobados'));
    }

    // 3. Postulantes reprobados
    public function reprobados()
    {
        $reprobados = Estudiante::whereHas('calificaciones', function($q) {
                $q->where('estado', 'reprobado');
            })
            ->with(['calificaciones.materia', 'inscripcion.grupo'])
            ->orderBy('apellidos')
            ->paginate(20);
        
        return view('admin.reportes.reprobados', compact('reprobados'));
    }

    // 4. Promedios generales
    public function promedios()
    {
        $estudiantes = Estudiante::with(['calificaciones.materia'])
            ->orderBy('apellidos')
            ->get()
            ->map(function($estudiante) {
                $estudiante->promedio_general = $estudiante->calificaciones->avg('promedio') ?? 0;
                $estudiante->materias_aprobadas = $estudiante->calificaciones->where('estado', 'aprobado')->count();
                return $estudiante;
            })
            ->sortByDesc('promedio_general');
        
        return view('admin.reportes.promedios', compact('estudiantes'));
    }

    // 5. Grupos habilitados
    public function grupos()
    {
        $resumen = Grupo::resumenGrupos();
        $grupos = Grupo::with(['docente', 'inscripciones.estudiante'])
            ->withCount('inscripciones')
            ->orderBy('turno')
            ->orderBy('codigo')
            ->get();
        
        return view('admin.reportes.grupos', compact('resumen', 'grupos'));
    }

    // 6. Estadísticas por materia
    public function estadisticasMaterias()
    {
        $materias = MateriaCup::where('estado', true)
            ->withCount(['calificaciones as total_evaluados' => function($q) {
                $q->where('estado', '!=', 'pendiente');
            }])
            ->withCount(['calificaciones as total_aprobados' => function($q) {
                $q->where('estado', 'aprobado');
            }])
            ->withCount(['calificaciones as total_reprobados' => function($q) {
                $q->where('estado', 'reprobado');
            }])
            ->get()
            ->map(function($materia) {
                $materia->promedio_notas = Calificacion::where('materia_id', $materia->id)
                    ->where('estado', '!=', 'pendiente')
                    ->avg('promedio') ?? 0;
                $materia->nota_mas_alta = Calificacion::where('materia_id', $materia->id)->max('promedio') ?? 0;
                $materia->nota_mas_baja = Calificacion::where('materia_id', $materia->id)
                    ->where('estado', '!=', 'pendiente')
                    ->min('promedio') ?? 0;
                return $materia;
            });
        
        return view('admin.reportes.estadisticas_materias', compact('materias'));
    }

    // 7. Docentes por grupos
    public function docentesGrupos()
    {
        $docentes = Docente::with(['grupos.inscripciones'])
            ->withCount('grupos')
            ->where('estado', true)
            ->orderBy('apellidos')
            ->get();
        
        return view('admin.reportes.docentes_grupos', compact('docentes'));
    }

    // 8. Grupos con mayor cantidad de aprobados
    public function gruposTop()
    {
        $grupos = Grupo::with(['docente', 'inscripciones.estudiante.calificaciones'])
            ->withCount('inscripciones')
            ->get()
            ->map(function($grupo) {
                $totalAprobados = 0;
                foreach($grupo->inscripciones as $inscripcion) {
                    if($inscripcion->estudiante && $inscripcion->estudiante->aproboCUP()) {
                        $totalAprobados++;
                    }
                }
                $grupo->total_aprobados = $totalAprobados;
                $grupo->porcentaje_aprobados = $grupo->inscripciones_count > 0 
                    ? round(($totalAprobados / $grupo->inscripciones_count) * 100, 1) 
                    : 0;
                return $grupo;
            })
            ->sortByDesc('porcentaje_aprobados');
        
        return view('admin.reportes.grupos_top', compact('grupos'));
    }
      public function exportarPostulantesPDF()
    {
        $estudiantes = Estudiante::with(['carreraInteres', 'inscripcion.grupo'])
            ->orderBy('apellidos')
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf.postulantes', compact('estudiantes'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('postulantes_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exportar aprobados a PDF.
     */
    public function exportarAprobadosPDF()
    {
        $aprobados = Estudiante::whereHas('calificaciones', function($q) {
                $q->where('estado', 'aprobado');
            }, '=', 4)
            ->with(['calificaciones.materia', 'inscripcion.grupo'])
            ->orderBy('apellidos')
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf.aprobados', compact('aprobados'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('aprobados_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exportar estadísticas por materia a PDF.
     */
    public function exportarEstadisticasPDF()
    {
        $materias = MateriaCup::where('estado', true)
            ->withCount(['calificaciones as total_evaluados'])
            ->withCount(['calificaciones as total_aprobados' => function($q) {
                $q->where('estado', 'aprobado');
            }])
            ->withCount(['calificaciones as total_reprobados' => function($q) {
                $q->where('estado', 'reprobado');
            }])
            ->get()
            ->map(function($materia) {
                $materia->promedio_notas = Calificacion::where('materia_id', $materia->id)->avg('promedio') ?? 0;
                $materia->nota_mas_alta = Calificacion::where('materia_id', $materia->id)->max('promedio') ?? 0;
                $materia->nota_mas_baja = Calificacion::where('materia_id', $materia->id)->min('promedio') ?? 0;
                $materia->porcentaje_aprobados = $materia->total_evaluados > 0 
                    ? round(($materia->total_aprobados / $materia->total_evaluados) * 100, 1) 
                    : 0;
                return $materia;
            });

        $pdf = Pdf::loadView('admin.reportes.pdf.estadisticas', compact('materias'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('estadisticas_materias_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exportar grupos a PDF.
     */
    public function exportarGruposPDF()
    {
        $resumen = Grupo::resumenGrupos();
        $grupos = Grupo::with(['docente', 'inscripciones.estudiante'])
            ->withCount('inscripciones')
            ->orderBy('turno')
            ->orderBy('codigo')
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf.grupos', compact('resumen', 'grupos'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('grupos_' . date('Y-m-d') . '.pdf');
    }
}
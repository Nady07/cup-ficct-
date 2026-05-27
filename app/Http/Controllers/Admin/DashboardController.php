<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Docente;
use App\Models\MateriaCup;
use App\Models\Carrera;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache de estadísticas (5-10 minutos)
        $stats = \Illuminate\Support\Facades\Cache::remember('dashboard_stats', 600, function () {
            return [
                'estudiantes' => Estudiante::count(),
                'grupos' => Grupo::count(),
                'inscripciones' => Inscripcion::count(),
                'inscripciones_pendientes' => Inscripcion::where('estado', 'pendiente')->count(),
                'inscripciones_confirmadas' => Inscripcion::where('estado', 'confirmado')->count(),
                'docentes' => Docente::count(),
                'materias' => MateriaCup::where('estado', true)->count(),
                'carreras' => Carrera::where('estado', true)->count(),
                'grupos_disponibles' => Grupo::whereColumn('estudiantes_inscritos', '<', 'capacidad_maxima')->count(),
                'grupos_llenos' => Grupo::whereColumn('estudiantes_inscritos', '>=', 'capacidad_maxima')->count(),
            ];
        });

        // Últimas inscripciones con eager loading (evita N+1 queries)
        $ultimasInscripciones = Inscripcion::with(['estudiante.carrera', 'grupo.materia', 'grupo.docente'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimasInscripciones'));
    }
}
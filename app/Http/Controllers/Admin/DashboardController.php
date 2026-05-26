<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Docente;
use App\Models\MateriaCup;
use App\Models\Carrera;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'estudiantes' => Estudiante::count(),
            'grupos' => Grupo::count(),
            'inscripciones' => Inscripcion::count(),
            'inscripciones_pendientes' => Inscripcion::where('estado', 'pendiente')->count(),
            'inscripciones_confirmadas' => Inscripcion::where('estado', 'confirmado')->count(),
            'docentes' => Docente::count(),
            'materias' => MateriaCup::count(),
            'carreras' => Carrera::count(),
            'grupos_disponibles' => Grupo::whereColumn('estudiantes_inscritos', '<', 'capacidad_maxima')->count(),
            'grupos_llenos' => Grupo::whereColumn('estudiantes_inscritos', '>=', 'capacidad_maxima')->count(),
        ];

        $ultimasInscripciones = Inscripcion::with(['estudiante', 'grupo'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimasInscripciones'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\MateriaCup;
use App\Models\RequisitoCup;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    /**
     * Dashboard del estudiante.
     * Muestra resumen de inscripciones, calificaciones y estado del CUP.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404, 'Estudiante no encontrado');
        }

        // Obtener inscripción activa con grupo y docente
        $inscripcion = Inscripcion::where('estudiante_id', $estudiante->id)
            ->with(['grupo.docente'])
            ->latest()
            ->first();

        // Obtener calificaciones con materia
        $calificaciones = Calificacion::where('estudiante_id', $estudiante->id)
            ->with('materia')
            ->get();

        // Usar los métodos del modelo (CORREGIDO)
        $promedio = $estudiante->promedio();
        $aprobadas = $estudiante->materiasAprobadas();
        $reprobadas = $estudiante->materiasReprobadas();
        $aproboCUP = $estudiante->aproboCUP();

        return view('estudiante.dashboard', compact(
            'estudiante',
            'inscripcion',
            'calificaciones',
            'promedio',
            'aprobadas',
            'reprobadas',
            'aproboCUP'
        ));
    }

    /**
     * Muestra el horario del estudiante según su grupo asignado.
     *
     * @return \Illuminate\View\View
     */
    public function horario()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        // Obtener el grupo del estudiante a través de la inscripción
        $inscripcion = Inscripcion::where('estudiante_id', $estudiante->id)
            ->where('estado', 'confirmado')
            ->with('grupo.docente')
            ->first();

        $grupo = $inscripcion ? $inscripcion->grupo : null;

        return view('estudiante.horario', compact('grupo', 'inscripcion'));
    }

    /**
     * Muestra las calificaciones del estudiante.
     *
     * @return \Illuminate\View\View
     */
    public function calificaciones()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        $calificaciones = Calificacion::where('estudiante_id', $estudiante->id)
            ->with('materia')
            ->get();

        $promedio = $estudiante->promedio();
        $aprobadas = $estudiante->materiasAprobadas();
        $reprobadas = $estudiante->materiasReprobadas();
        $aproboCUP = $estudiante->aproboCUP();

        return view('estudiante.calificaciones', compact(
            'calificaciones',
            'promedio',
            'aprobadas',
            'reprobadas',
            'aproboCUP'
        ));
    }

    /**
     * Muestra los docentes asignados al grupo del estudiante.
     *
     * @return \Illuminate\View\View
     */
    public function docentes()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        // Obtener docente del grupo del estudiante
        $inscripcion = Inscripcion::where('estudiante_id', $estudiante->id)
            ->where('estado', 'confirmado')
            ->with('grupo.docente')
            ->first();

        $docente = $inscripcion ? $inscripcion->grupo->docente : null;

        return view('estudiante.docentes', compact('docente'));
    }

    /**
     * Muestra información del CUP (materias y requisitos).
     *
     * @return \Illuminate\View\View
     */
    public function cup()
    {
        $materiasCup = MateriaCup::where('estado', true)
            ->orderBy('orden')
            ->get();

        $requisitos = RequisitoCup::where('tipo', 'estudiante')
            ->where('estado', true)
            ->orderBy('obligatorio', 'desc')
            ->get();

        return view('estudiante.cup-info', compact('materiasCup', 'requisitos'));
    }
}
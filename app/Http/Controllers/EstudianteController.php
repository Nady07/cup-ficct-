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
     * Dashboard del estudiante
     */
    public function dashboard()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404, 'Estudiante no encontrado');
        }

        // Datos para el dashboard
        $inscripciones = Inscripcion::where('estudiante_id', $estudiante->id)
            ->with(['grupo' => function ($query) {
                $query->with('docente');
            }])
            ->get();

        $calificaciones = Calificacion::where('estudiante_id', $estudiante->id)
            ->with('materia')
            ->get();

        // Calcular promedio
        $promedio = $calificaciones->avg('nota') ?? 0;
        $promedio = round($promedio, 2);

        // Contar materias aprobadas
        $aprobadas = $calificaciones->where('nota', '>=', 51)->count();
        $reprobadas = $calificaciones->where('nota', '<', 51)->count();

        return view('estudiante.dashboard', compact(
            'estudiante',
            'inscripciones',
            'calificaciones',
            'promedio',
            'aprobadas',
            'reprobadas'
        ));
    }

    /**
     * Mostrar horario del estudiante
     */
    public function horario()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        $grupos = Grupo::whereIn('id', 
            Inscripcion::where('estudiante_id', $estudiante->id)
                ->where('estado', 'activa')
                ->pluck('grupo_id')
        )->with('docente')->get();

        // Agrupar por turno
        $turnos = $grupos->groupBy('turno');

        return view('estudiante.horario', compact('grupos', 'turnos'));
    }

    /**
     * Mostrar materias inscritas
     */
    public function materias()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        // Materias inscritas
        $materias = [];
        $inscripciones = Inscripcion::where('estudiante_id', $estudiante->id)
            ->with('grupo')
            ->get();

        foreach ($inscripciones as $insc) {
            $grupo = $insc->grupo;
            $calificacion = Calificacion::where('estudiante_id', $estudiante->id)
                ->where('materia_id', $grupo->materia_id ?? null)
                ->first();

            $materias[] = [
                'inscripcion' => $insc,
                'grupo' => $grupo,
                'calificacion' => $calificacion,
            ];
        }

        return view('estudiante.materias-inscritas', compact('materias'));
    }

    /**
     * Mostrar docentes
     */
    public function docentes()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        // Obtener docentes de las clases inscritas
        $docenteIds = Grupo::whereIn('id',
            Inscripcion::where('estudiante_id', $estudiante->id)
                ->where('estado', 'activa')
                ->pluck('grupo_id')
        )->pluck('docente_id')->unique();

        $docentes = Docente::whereIn('id', $docenteIds)
            ->where('estado', 'activo')
            ->get();

        return view('estudiante.docentes-lista', compact('docentes'));
    }

    /**
     * Mostrar información del CUP
     */
    public function cup()
    {
        $materiasCup = MateriaCup::where('estado', 'activa')
            ->orderBy('orden')
            ->get();

        $requisitos = RequisitoCup::with('materia')->get();

        // Agrupar requisitos por materia
        $requisitosPorMateria = $requisitos->groupBy('materia_id');

        return view('estudiante.cup-info', compact('materiasCup', 'requisitosPorMateria'));
    }

    public function edit(Estudiante $estudiante)
{
    $carreras = Carrera::where('estado', true)->get();
    $grupos = Grupo::with('docente')->where('estado', true)->get();
    return view('admin.estudiantes.edit', compact('estudiante', 'carreras', 'grupos'));
}

public function update(Request $request, Estudiante $estudiante)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'ci' => 'required|string|max:20|unique:estudiantes,ci,' . $estudiante->id,
        'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string',
        'fecha_nacimiento' => 'required|date',
        'colegio_procedencia' => 'nullable|string|max:200',
        'anio_graduacion' => 'nullable|integer',
        'carrera_interes_id' => 'nullable|exists:carreras,id',
        'estado' => 'boolean',
    ]);

    $estudiante->update($validated);

    // Si también actualiza la inscripción
    if ($request->filled('grupo_id')) {
        $inscripcion = $estudiante->inscripcion;
        if ($inscripcion) {
            $inscripcion->update([
                'grupo_id' => $request->grupo_id,
                'estado' => $request->inscripcion_estado ?? $inscripcion->estado,
                'monto_pagado' => $request->monto_pagado,
                'numero_boleta' => $request->numero_boleta,
            ]);
        }
    }

    return redirect()->route('admin.estudiantes.show', $estudiante)
        ->with('success', 'Estudiante actualizado exitosamente.');
}

public function updateRequisitos(Request $request, Estudiante $estudiante)
{
    $inscripcion = $estudiante->inscripcion;
    if ($inscripcion) {
        $inscripcion->update([
            'requisitos_completos' => $request->requisitos_completos ?? false,
        ]);
    }

    return back()->with('success', 'Requisitos actualizados.');
}
}

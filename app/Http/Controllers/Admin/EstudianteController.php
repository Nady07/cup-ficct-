<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\MateriaCup;
use App\Models\Grupo;
use App\Models\Carrera;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Listado de estudiantes con filtros inteligentes.
     */
    public function index(Request $request)
    {
        $query = Estudiante::with(['carreraInteres', 'inscripcion.grupo', 'calificaciones'])
            ->whereIn('estado_flujo', ['pago_confirmado', 'inscrito', 'cup_aprobado'])
            ->orderBy('apellidos');

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = strtolower($request->buscar);
            $query->where(function($q) use ($buscar) {
                $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$buscar}%"])
                  ->orWhereRaw('LOWER(apellidos) LIKE ?', ["%{$buscar}%"])
                  ->orWhere('ci', 'LIKE', "%{$buscar}%");
            });
        }

        // Filtro por carrera
        if ($request->filled('carrera_id')) {
            $query->where('carrera_interes_id', $request->carrera_id);
        }

        // Filtro por estado de inscripción
        if ($request->filled('estado_inscripcion')) {
            $query->whereHas('inscripcion', function($q) use ($request) {
                $q->where('estado', $request->estado_inscripcion);
            });
        }

        $estudiantes = $query->paginate(20)->appends($request->query());
        $carreras = Carrera::where('estado', true)->orderBy('nombre')->get();

        return view('admin.estudiantes.index', compact('estudiantes', 'carreras'));
    }

    /**
     * Mostrar perfil completo del estudiante.
     */
    public function show(Estudiante $estudiante)
    {
        $estudiante->load([
            'carreraInteres',
            'carreraOpcion2',
            'inscripcion.grupo.docente',
            'calificaciones.materia',
            'calificaciones.registradoPor'
        ]);

        $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();

        // Calcular estadísticas usando los métodos del modelo
        $promedio = $estudiante->promedio();
        $aprobadas = $estudiante->materiasAprobadas();
        $reprobadas = $estudiante->materiasReprobadas();
        $totalMaterias = $materias->count();
        $aprobadoCUP = $estudiante->aproboCUP();
        $porcentajeCompletado = $totalMaterias > 0 ? round(($aprobadas / $totalMaterias) * 100) : 0;

        // Verificación de requisitos (AHORA DESDE EL ESTUDIANTE)
        $requisitosCompletados = $estudiante->requisitos_completos;

        return view('admin.estudiantes.show', compact(
            'estudiante',
            'materias',
            'promedio',
            'aprobadas',
            'reprobadas',
            'totalMaterias',
            'aprobadoCUP',
            'porcentajeCompletado',
            'requisitosCompletados'
        ));
    }

    /**
     * Formulario de edición del estudiante.
     */
    public function edit(Estudiante $estudiante)
    {
        $estudiante->load('inscripcion');
        $carreras = Carrera::where('estado', true)->orderBy('nombre')->get();
        $grupos = Grupo::with('docente')->where('estado', true)->orderBy('turno')->orderBy('codigo')->get();

        return view('admin.estudiantes.edit', compact('estudiante', 'carreras', 'grupos'));
    }

    /**
     * Actualizar datos del estudiante.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:estudiantes,ci,' . $estudiante->id,
            'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'fecha_nacimiento' => 'required|date',
            'colegio_procedencia' => 'nullable|string|max:200',
            'anio_graduacion' => 'nullable|integer|min:2000|max:2030',
            'carrera_interes_id' => 'nullable|exists:carreras,id',
            'estado' => 'boolean',
        ]);

        $estudiante->update($validated);

        // Si también actualiza la inscripción
        if ($estudiante->inscripcion && $request->filled('grupo_id')) {
            $estudiante->inscripcion->update([
                'grupo_id' => $request->grupo_id,
                'estado' => $request->inscripcion_estado ?? $estudiante->inscripcion->estado,
                'monto_pagado' => $request->monto_pagado,
                'numero_boleta' => $request->numero_boleta,
            ]);
        }

        return redirect()->route('admin.estudiantes.show', $estudiante)
            ->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Actualizar requisitos del estudiante.
     */
    public function updateRequisitos(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'requisitos_completos' => 'required|boolean',
        ]);

        // ✅ CORREGIDO: Se actualiza en el estudiante, no en la inscripción
        $estudiante->update([
            'requisitos_completos' => $request->requisitos_completos,
        ]);

        return back()->with('success', 'Requisitos actualizados correctamente.');
    }

    /**
     * Aprobar requisitos del postulante.
     * Cambia el estado a 'requisitos_aprobados' y permite proceder al pago.
     */
    public function aprobarRequisitos(Estudiante $estudiante)
    {
        if ($estudiante->requisitos_completos) {
            $estudiante->update([
                'estado_flujo' => Estudiante::ESTADO_REQUISITOS_APROBADOS,
                'fecha_aprobacion_requisitos' => now(),
            ]);
            return back()->with('success', 'Requisitos aprobados. El estudiante puede proceder al pago.');
        }
        return back()->with('error', 'El estudiante no tiene todos los requisitos completos.');
    }

    /**
     * Confirmar pago del estudiante.
     * Crea la inscripción automáticamente si no existe.
     */
    public function confirmarPago(Request $request, Estudiante $estudiante)
    {
        $estudiante->update([
            'estado_flujo' => Estudiante::ESTADO_PAGO_CONFIRMADO,
            'fecha_pago' => now(),
        ]);

        // Crear inscripción automáticamente si no existe
        if (!$estudiante->inscripcion) {
            Inscripcion::create([
                'estudiante_id' => $estudiante->id,
                'estado' => Estudiante::ESTADO_PAGO_CONFIRMADO,
                'fecha_inscripcion' => now(),
            ]);
        }

        return back()->with('success', 'Pago confirmado. El estudiante puede ser asignado a un grupo.');
    }
    /**
 * Listado de postulantes que enviaron requisitos (pendientes de revisión).
 */
public function postulantes(Request $request)
{
    $query = Estudiante::with(['carreraInteres'])
        ->whereIn('estado_flujo', ['postulante', 'requisitos_aprobados'])
        ->orderBy('apellidos');

    // Filtro de búsqueda
    if ($request->filled('buscar')) {
        $buscar = strtolower($request->buscar);
        $query->where(function($q) use ($buscar) {
            $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$buscar}%"])
              ->orWhereRaw('LOWER(apellidos) LIKE ?', ["%{$buscar}%"])
              ->orWhere('ci', 'LIKE', "%{$buscar}%");
        });
    }

    // Filtro por carrera
    if ($request->filled('carrera_id')) {
        $query->where('carrera_interes_id', $request->carrera_id);
    }

    $estudiantes = $query->paginate(20)->appends($request->query());
    $carreras = Carrera::where('estado', true)->orderBy('nombre')->get();

    return view('admin.estudiantes.postulantes', compact('estudiantes', 'carreras'));
}
}
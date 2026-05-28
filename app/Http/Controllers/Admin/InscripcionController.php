<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InscripcionController extends Controller
{
    /**
     * Muestra el listado de inscripciones con filtros.
     */
    public function index(Request $request)
    {
        $query = Inscripcion::with(['estudiante.carreraInteres', 'grupo.docente']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro de búsqueda por CI o nombre del estudiante
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function($q) use ($buscar) {
                $q->where('ci', 'LIKE', "%{$buscar}%")
                  ->orWhere('apellidos', 'LIKE', "%{$buscar}%")
                  ->orWhere('nombre', 'LIKE', "%{$buscar}%");
            });
        }

        $inscripciones = $query->latest()->paginate(20)->appends($request->query());

        return view('admin.inscripciones.index', compact('inscripciones'));
    }

    /**
     * Crear una nueva inscripción para un estudiante.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'grupo_id'      => 'required|exists:grupos,id',
        ], [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'estudiante_id.exists'   => 'El estudiante seleccionado no es válido.',
            'grupo_id.required'      => 'Debe seleccionar un grupo.',
            'grupo_id.exists'        => 'El grupo seleccionado no es válido.',
        ]);

        // Verificar que el estudiante no tenga ya una inscripción activa
        $existente = Inscripcion::where('estudiante_id', $validated['estudiante_id'])
            ->whereIn('estado', ['pendiente', 'confirmado'])
            ->first();

        if ($existente) {
            return back()
                ->withInput()
                ->with('error', 'El estudiante ya tiene una inscripción activa.');
        }

        // Verificar que el grupo tenga cupos disponibles
        $grupo = Grupo::findOrFail($validated['grupo_id']);
        if (!$grupo->tieneCupo()) {
            return back()
                ->withInput()
                ->with('error', 'El grupo seleccionado no tiene cupos disponibles.');
        }

        // Crear la inscripción
        Inscripcion::create([
            'estudiante_id' => $validated['estudiante_id'],
            'grupo_id'      => $validated['grupo_id'],
            'estado'        => 'pendiente',
            'fecha_inscripcion' => now(),
        ]);

        Log::info('Inscripción creada por administrador', [
            'user_id'       => auth()->id(),
            'estudiante_id' => $validated['estudiante_id'],
            'grupo_id'      => $validated['grupo_id'],
        ]);

        return redirect()
            ->route('admin.inscripciones.index')
            ->with('success', 'Inscripción creada exitosamente.');
    }

    /**
     * Actualiza el estado de una inscripción.
     * Al confirmar, incrementa el contador de estudiantes del grupo.
     */
    public function updateEstado(Request $request, Inscripcion $inscripcion)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmado,rechazado,completado',
        ]);

        $estadoAnterior = $inscripcion->estado;
        $nuevoEstado = $request->estado;

        // Si se confirma, verificar cupo del grupo
        if ($nuevoEstado === 'confirmado' && $estadoAnterior !== 'confirmado') {
            $grupo = $inscripcion->grupo;
            if (!$grupo->tieneCupo()) {
                return back()->with('error', 'El grupo no tiene cupos disponibles.');
            }
            $grupo->increment('estudiantes_inscritos');
        }

        // Si se desconfirma (de confirmado a otro estado), decrementar contador
        if ($estadoAnterior === 'confirmado' && $nuevoEstado !== 'confirmado') {
            $inscripcion->grupo->decrement('estudiantes_inscritos');
        }

        $inscripcion->update(['estado' => $nuevoEstado]);

        Log::info('Estado de inscripción actualizado', [
            'user_id'         => auth()->id(),
            'inscripcion_id'  => $inscripcion->id,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo'    => $nuevoEstado,
        ]);

        return back()->with('success', 'Estado de inscripción actualizado correctamente.');
    }
}
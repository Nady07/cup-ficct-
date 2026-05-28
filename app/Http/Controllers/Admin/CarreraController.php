<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarreraController extends Controller
{
    /**
     * Muestra el listado de carreras con indicadores de cupos.
     * Incluye conteo de estudiantes y cálculo de disponibilidad.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cargamos carreras con conteo de estudiantes y calculamos disponibilidad
        $carreras = Carrera::withCount('estudiantes')
            ->orderBy('nombre')
            ->paginate(10);

        return view('admin.carreras.index', compact('carreras'));
    }

    /**
     * Muestra el formulario para crear una nueva carrera.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.carreras.create');
    }

    /**
     * Almacena una nueva carrera con su configuración de cupos.
     * Regla del examen: Cada carrera tiene cupos limitados por gestión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validación de campos incluyendo CUPOS (requisito del examen)
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'codigo'           => 'required|string|max:20|unique:carreras',
            'descripcion'      => 'nullable|string|max:500',
            'duracion'         => 'required|string|max:50',
            'titulo_otorgado'  => 'required|string|max:255',
            'cupos'            => 'required|integer|min:1|max:999', // CAMPO NUEVO REQUERIDO
        ], [
            'nombre.required'           => 'El nombre de la carrera es obligatorio.',
            'codigo.required'           => 'El código de la carrera es obligatorio.',
            'codigo.unique'             => 'Este código ya está en uso por otra carrera.',
            'duracion.required'         => 'La duración de la carrera es obligatoria.',
            'titulo_otorgado.required'  => 'El título otorgado es obligatorio.',
            'cupos.required'            => 'Debe especificar la cantidad de cupos disponibles.',
            'cupos.integer'             => 'Los cupos deben ser un número entero.',
            'cupos.min'                 => 'Debe haber al menos 1 cupo disponible.',
            'cupos.max'                 => 'El máximo de cupos es 999.',
        ]);

        // 2. Creación de la carrera (estado activo por defecto)
        $carrera = Carrera::create([
            'nombre'          => $validated['nombre'],
            'codigo'          => $validated['codigo'],
            'descripcion'     => $validated['descripcion'] ?? null,
            'duracion'        => $validated['duracion'],
            'titulo_otorgado' => $validated['titulo_otorgado'],
            'cupos'           => $validated['cupos'],
            'estado'          => true,
        ]);

        // 3. Registro de auditoría
        Log::info('Carrera creada por administrador', [
            'user_id'    => auth()->id(),
            'carrera_id' => $carrera->id,
            'nombre'     => $carrera->nombre,
            'cupos'      => $carrera->cupos,
            'ip'         => $request->ip(),
            'fecha'      => now()->toDateTimeString(),
        ]);

        // 4. Redirección con mensaje de éxito
        return redirect()
            ->route('admin.carreras.index')
            ->with('success', 'Carrera creada exitosamente. Cupos disponibles: ' . $carrera->cupos);
    }

    /**
     * Muestra el formulario de edición de una carrera.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\View\View
     */
    public function edit(Carrera $carrera)
    {
        // Cargamos información adicional de cupos para el formulario
        $estudiantesInscritos = $carrera->estudiantes()->count();
        $cuposDisponibles = $carrera->cupos - $estudiantesInscritos;

        return view('admin.carreras.edit', compact('carrera', 'estudiantesInscritos', 'cuposDisponibles'));
    }

    /**
     * Actualiza los datos de una carrera existente.
     * Permite modificar cupos incluso si ya hay estudiantes inscritos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Carrera $carrera)
    {
        // 1. Validación con excepción de código único para esta carrera
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'codigo'           => 'required|string|max:20|unique:carreras,codigo,' . $carrera->id,
            'descripcion'      => 'nullable|string|max:500',
            'duracion'         => 'required|string|max:50',
            'titulo_otorgado'  => 'required|string|max:255',
            'cupos'            => 'required|integer|min:1|max:999',
            'estado'           => 'boolean',
        ], [
            'nombre.required'           => 'El nombre de la carrera es obligatorio.',
            'codigo.required'           => 'El código de la carrera es obligatorio.',
            'codigo.unique'             => 'Este código ya está en uso por otra carrera.',
            'duracion.required'         => 'La duración de la carrera es obligatoria.',
            'titulo_otorgado.required'  => 'El título otorgado es obligatorio.',
            'cupos.required'            => 'Debe especificar la cantidad de cupos disponibles.',
            'cupos.min'                 => 'Debe haber al menos 1 cupo disponible.',
        ]);

        // 2. Validación adicional: No permitir cupos menores a estudiantes ya inscritos
        $estudiantesInscritos = $carrera->estudiantes()->count();
        if ($validated['cupos'] < $estudiantesInscritos) {
            return back()
                ->withInput()
                ->with('error', "No puede reducir los cupos a {$validated['cupos']}. Ya hay {$estudiantesInscritos} estudiantes inscritos.");
        }

        // 3. Actualización de la carrera
        $carrera->update($validated);

        // 4. Registro de auditoría
        Log::info('Carrera actualizada por administrador', [
            'user_id'              => auth()->id(),
            'carrera_id'           => $carrera->id,
            'nombre'               => $carrera->nombre,
            'cupos_anteriores'     => $carrera->getOriginal('cupos'),
            'cupos_nuevos'         => $carrera->cupos,
            'ip'                   => $request->ip(),
            'fecha'                => now()->toDateTimeString(),
        ]);

        // 5. Redirección con mensaje de éxito
        return redirect()
            ->route('admin.carreras.index')
            ->with('success', 'Carrera actualizada exitosamente. Cupos: ' . $carrera->cupos);
    }

    /**
     * Elimina una carrera del sistema.
     * Solo se permite si no tiene estudiantes inscritos.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Carrera $carrera)
    {
        // Verificar si hay estudiantes inscritos en esta carrera
        if ($carrera->estudiantes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la carrera. Tiene estudiantes inscritos.');
        }

        // Guardar información para auditoría antes de eliminar
        $infoEliminada = [
            'id'     => $carrera->id,
            'nombre' => $carrera->nombre,
            'codigo' => $carrera->codigo,
        ];

        try {
            $carrera->delete();

            Log::warning('Carrera eliminada por administrador', [
                'user_id'      => auth()->id(),
                'datos_previos'=> $infoEliminada,
                'ip'           => request()->ip(),
                'fecha'        => now()->toDateTimeString(),
            ]);

            return redirect()
                ->route('admin.carreras.index')
                ->with('success', 'Carrera "' . $infoEliminada['nombre'] . '" eliminada exitosamente.');
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar carrera', [
                'user_id'    => auth()->id(),
                'carrera_id' => $carrera->id,
                'error'      => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al eliminar la carrera. Intente nuevamente.');
        }
    }
}
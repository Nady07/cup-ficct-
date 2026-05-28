<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MateriaCup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MateriaController extends Controller
{
    /**
     * Muestra el listado de materias con paginación.
     * Las materias son: Computación, Matemáticas, Inglés, Física (según el examen).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $materias = MateriaCup::orderBy('orden')
            ->paginate(10);

        return view('admin.materias.index', compact('materias'));
    }

    /**
     * Muestra el formulario para crear una nueva materia.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.materias.create');
    }

    /**
     * Almacena una nueva materia en el sistema.
     * NOTA: El campo 'nota_minima' se guarda pero NO se usa para la aprobación.
     * La aprobación usa la constante Calificacion::NOTA_MINIMA_APROBACION = 60.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validación de campos obligatorios
        $validated = $request->validate([
            'nombre'         => 'required|string|max:255',
            'codigo'         => 'required|string|max:20|unique:materias_cup',
            'descripcion'    => 'nullable|string|max:500',
            'nota_minima'    => 'required|numeric|min:0|max:100',
            'valor_puntaje'  => 'required|numeric|min:0|max:100',
            'orden'          => 'required|integer|min:1',
        ], [
            'nombre.required'        => 'El nombre de la materia es obligatorio.',
            'nombre.max'             => 'El nombre no debe exceder los 255 caracteres.',
            'codigo.required'        => 'El código de la materia es obligatorio.',
            'codigo.unique'          => 'Este código ya está en uso por otra materia.',
            'codigo.max'             => 'El código no debe exceder los 20 caracteres.',
            'nota_minima.required'   => 'La nota mínima es obligatoria.',
            'nota_minima.numeric'    => 'La nota mínima debe ser un valor numérico.',
            'nota_minima.min'        => 'La nota mínima no puede ser menor a 0.',
            'nota_minima.max'        => 'La nota mínima no puede ser mayor a 100.',
            'valor_puntaje.required' => 'El valor del puntaje es obligatorio.',
            'valor_puntaje.numeric'  => 'El valor del puntaje debe ser numérico.',
            'valor_puntaje.min'      => 'El puntaje no puede ser menor a 0.',
            'valor_puntaje.max'      => 'El puntaje no puede ser mayor a 100.',
            'orden.required'         => 'El orden es obligatorio.',
            'orden.integer'          => 'El orden debe ser un número entero.',
            'orden.min'              => 'El orden debe ser al menos 1.',
        ]);

        // 2. Creación de la materia (estado activo por defecto)
        $materia = MateriaCup::create([
            'nombre'        => $validated['nombre'],
            'codigo'        => strtoupper($validated['codigo']), // Código en mayúsculas
            'descripcion'   => $validated['descripcion'] ?? null,
            'nota_minima'   => $validated['nota_minima'],
            'valor_puntaje' => $validated['valor_puntaje'],
            'orden'         => $validated['orden'],
            'estado'        => true,
        ]);

        // 3. Registro de auditoría
        Log::info('Materia creada por administrador', [
            'user_id'    => auth()->id(),
            'materia_id' => $materia->id,
            'nombre'     => $materia->nombre,
            'codigo'     => $materia->codigo,
            'ip'         => $request->ip(),
            'fecha'      => now()->toDateTimeString(),
        ]);

        // 4. Redirección con mensaje de éxito
        return redirect()
            ->route('admin.materias.index')
            ->with('success', "Materia \"{$materia->nombre}\" creada exitosamente.");
    }

    /**
     * Muestra el formulario de edición de una materia.
     *
     * @param  \App\Models\MateriaCup  $materia
     * @return \Illuminate\View\View
     */
    public function edit(MateriaCup $materia)
    {
        return view('admin.materias.edit', compact('materia'));
    }

    /**
     * Actualiza los datos de una materia existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MateriaCup  $materia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, MateriaCup $materia)
    {
        // 1. Validación con excepción de código único para esta materia
        $validated = $request->validate([
            'nombre'         => 'required|string|max:255',
            'codigo'         => 'required|string|max:20|unique:materias_cup,codigo,' . $materia->id,
            'descripcion'    => 'nullable|string|max:500',
            'nota_minima'    => 'required|numeric|min:0|max:100',
            'valor_puntaje'  => 'required|numeric|min:0|max:100',
            'orden'          => 'required|integer|min:1',
            'estado'         => 'boolean',
        ], [
            'nombre.required'        => 'El nombre de la materia es obligatorio.',
            'codigo.required'        => 'El código de la materia es obligatorio.',
            'codigo.unique'          => 'Este código ya está en uso por otra materia.',
            'nota_minima.required'   => 'La nota mínima es obligatoria.',
            'valor_puntaje.required' => 'El valor del puntaje es obligatorio.',
            'orden.required'         => 'El orden es obligatorio.',
        ]);

        // 2. Convertir código a mayúsculas para consistencia
        $validated['codigo'] = strtoupper($validated['codigo']);

        // 3. Guardar datos originales para el log
        $datosOriginales = $materia->getOriginal();

        // 4. Actualización de la materia
        $materia->update($validated);

        // 5. Registro de auditoría con cambios realizados
        Log::info('Materia actualizada por administrador', [
            'user_id'    => auth()->id(),
            'materia_id' => $materia->id,
            'nombre'     => $materia->nombre,
            'cambios'    => $materia->getChanges(),
            'ip'         => $request->ip(),
            'fecha'      => now()->toDateTimeString(),
        ]);

        // 6. Redirección con mensaje de éxito
        return redirect()
            ->route('admin.materias.index')
            ->with('success', "Materia \"{$materia->nombre}\" actualizada exitosamente.");
    }

    /**
     * Elimina una materia del sistema.
     * Solo se permite si no tiene calificaciones asociadas.
     *
     * @param  \App\Models\MateriaCup  $materia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MateriaCup $materia)
    {
        // 1. Verificar si hay calificaciones asociadas
        if ($materia->calificaciones()->count() > 0) {
            return back()->with(
                'error', 
                "No se puede eliminar la materia \"{$materia->nombre}\". Tiene calificaciones registradas."
            );
        }

        // 2. Guardar información para auditoría antes de eliminar
        $infoEliminada = [
            'id'     => $materia->id,
            'nombre' => $materia->nombre,
            'codigo' => $materia->codigo,
        ];

        // 3. Eliminación con manejo de errores
        try {
            $materia->delete();

            Log::warning('Materia eliminada por administrador', [
                'user_id'      => auth()->id(),
                'datos_previos'=> $infoEliminada,
                'ip'           => request()->ip(),
                'fecha'        => now()->toDateTimeString(),
            ]);

            return redirect()
                ->route('admin.materias.index')
                ->with('success', "Materia \"{$infoEliminada['nombre']}\" eliminada exitosamente.");
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar materia', [
                'user_id'    => auth()->id(),
                'materia_id' => $materia->id,
                'error'      => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al eliminar la materia. Intente nuevamente.');
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\MateriaCup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalificacionController extends Controller
{
    /**
     * Muestra el listado de calificaciones con paginación.
     * Solo accesible por administradores para revisión y edición.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cargamos las calificaciones con sus relaciones para evitar consultas N+1
        $calificaciones = Calificacion::with(['estudiante', 'materia', 'registradoPor'])
            ->latest()
            ->paginate(15);
        
        // Datos necesarios para los formularios de filtrado o creación rápida
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();

        return view('admin.calificaciones.index', compact('calificaciones', 'estudiantes', 'materias'));
    }

    /**
     * Almacena una nueva calificación aplicando todas las reglas de negocio.
     *
     * Reglas del examen:
     * - Máximo 3 exámenes por estudiante por materia
     * - Notas entre 0 y 100
     * - Promedio >= 60 es APROBADO, menor es REPROBADO
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validación de campos obligatorios y reglas básicas
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id'    => 'required|exists:materias_cup,id',
            'nota1'         => 'required|numeric|min:0|max:100',
            'nota2'         => 'required|numeric|min:0|max:100',
            'nota3'         => 'required|numeric|min:0|max:100',
        ], [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'estudiante_id.exists'   => 'El estudiante seleccionado no es válido.',
            'materia_id.required'    => 'Debe seleccionar una materia.',
            'materia_id.exists'      => 'La materia seleccionada no es válida.',
            'nota1.required'         => 'La nota del primer examen es obligatoria.',
            'nota2.required'         => 'La nota del segundo examen es obligatoria.',
            'nota3.required'         => 'La nota del tercer examen es obligatoria.',
            'nota1.numeric'          => 'Las notas deben ser valores numéricos.',
            'nota2.numeric'          => 'Las notas deben ser valores numéricos.',
            'nota3.numeric'          => 'Las notas deben ser valores numéricos.',
            'nota1.min'              => 'Las notas no pueden ser menores a 0.',
            'nota2.min'              => 'Las notas no pueden ser menores a 0.',
            'nota3.min'              => 'Las notas no pueden ser menores a 0.',
            'nota1.max'              => 'Las notas no pueden ser mayores a 100.',
            'nota2.max'              => 'Las notas no pueden ser mayores a 100.',
            'nota3.max'              => 'Las notas no pueden ser mayores a 100.',
        ]);

        // 2. Regla de negocio crítica: Verificar que no exceda los 3 exámenes por materia
        $cantidadExamenes = Calificacion::where('estudiante_id', $validated['estudiante_id'])
            ->where('materia_id', $validated['materia_id'])
            ->count();

        if ($cantidadExamenes >= 3) {
            return back()
                ->withInput()
                ->with('error', 'Límite de exámenes alcanzado. El estudiante ya tiene 3 calificaciones en esta materia.');
        }

        // 3. Verificar que no exista un registro exactamente igual (duplicado)
        $existente = Calificacion::where('estudiante_id', $validated['estudiante_id'])
            ->where('materia_id', $validated['materia_id'])
            ->where('nota1', $validated['nota1'])
            ->where('nota2', $validated['nota2'])
            ->where('nota3', $validated['nota3'])
            ->first();

        if ($existente) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe un registro idéntico para este estudiante en esta materia.');
        }

        // 4. Creación del registro
        $calificacion = Calificacion::create([
            'estudiante_id'  => $validated['estudiante_id'],
            'materia_id'     => $validated['materia_id'],
            'nota1'          => $validated['nota1'],
            'nota2'          => $validated['nota2'],
            'nota3'          => $validated['nota3'],
            'promedio'       => 0,
            'estado'         => 'calculando',
            'registrado_por' => auth()->id(),
        ]);

        // 5. Aplicar reglas de negocio del examen (método combinado)
        $calificacion->calcularYActualizarEstado();
        $calificacion->save();

        // 6. Registro de auditoría profesional
        Log::info('Calificación creada por administrador', [
            'user_id'          => auth()->id(),
            'calificacion_id'  => $calificacion->id,
            'estudiante_id'    => $calificacion->estudiante_id,
            'materia_id'       => $calificacion->materia_id,
            'promedio'         => $calificacion->promedio,
            'estado'           => $calificacion->estado,
            'ip'               => $request->ip(),
            'fecha'            => now()->toDateTimeString(),
        ]);

        // 7. Redirección con mensaje de éxito
        return redirect()
            ->route('admin.calificaciones.index')
            ->with('success', 'Calificación registrada exitosamente. Promedio: ' . $calificacion->promedio . ' - Estado: ' . $calificacion->estado);
    }

    /**
     * Muestra el formulario para crear una nueva calificación.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();
        return view('admin.calificaciones.create', compact('estudiantes', 'materias'));
    }

    /**
     * Muestra el formulario de edición con los datos actuales de la calificación.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();

        return view('admin.calificaciones.edit', compact('calificacion', 'estudiantes', 'materias'));
    }

    /**
     * Actualiza una calificación existente.
     * Permite al administrador corregir errores en las notas registradas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // 1. Buscamos la calificación o devolvemos error 404
        $calificacion = Calificacion::findOrFail($id);

        // 2. Validación completa incluyendo los IDs
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id'    => 'required|exists:materias_cup,id',
            'nota1'         => 'required|numeric|min:0|max:100',
            'nota2'         => 'required|numeric|min:0|max:100',
            'nota3'         => 'required|numeric|min:0|max:100',
        ], [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'estudiante_id.exists'   => 'El estudiante seleccionado no es válido.',
            'materia_id.required'    => 'Debe seleccionar una materia.',
            'materia_id.exists'      => 'La materia seleccionada no es válida.',
            'nota1.required'         => 'La nota del primer examen es obligatoria.',
            'nota2.required'         => 'La nota del segundo examen es obligatoria.',
            'nota3.required'         => 'La nota del tercer examen es obligatoria.',
        ]);

        // 3. Verificar que no exceda los 3 exámenes (excluyendo el registro actual)
        $cantidadExamenes = Calificacion::where('estudiante_id', $validated['estudiante_id'])
            ->where('materia_id', $validated['materia_id'])
            ->where('id', '!=', $calificacion->id)
            ->count();

        if ($cantidadExamenes >= 3) {
            return back()
                ->withInput()
                ->with('error', 'No se puede actualizar. El estudiante ya tiene 3 exámenes en esta materia.');
        }

        // 4. Verificar que no exista otro registro idéntico (excluyendo este)
        $existente = Calificacion::where('estudiante_id', $validated['estudiante_id'])
            ->where('materia_id', $validated['materia_id'])
            ->where('nota1', $validated['nota1'])
            ->where('nota2', $validated['nota2'])
            ->where('nota3', $validated['nota3'])
            ->where('id', '!=', $calificacion->id)
            ->first();

        if ($existente) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe un registro idéntico para este estudiante en esta materia.');
        }

        // 5. Actualizamos los datos validados
        $calificacion->update($validated);

        // 6. Recalculamos promedio y estado según reglas del examen (método combinado)
        $calificacion->calcularYActualizarEstado();
        $calificacion->registrado_por = auth()->id();
        $calificacion->save();

        // 7. Auditoría de modificación
        Log::info('Calificación actualizada por administrador', [
            'user_id'          => auth()->id(),
            'calificacion_id'  => $calificacion->id,
            'nuevo_promedio'   => $calificacion->promedio,
            'nuevo_estado'     => $calificacion->estado,
            'ip'               => $request->ip(),
            'fecha'            => now()->toDateTimeString(),
        ]);

        // 8. Redirección con mensaje de éxito detallado
        return redirect()
            ->route('admin.calificaciones.index')
            ->with('success', 'Calificación actualizada correctamente. Nuevo promedio: ' . $calificacion->promedio . ' - Estado: ' . $calificacion->estado);
    }

    /**
     * Elimina una calificación del sistema.
     * Uso exclusivo del administrador para correcciones mayores.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        
        // Guardamos información para el log antes de eliminar
        $infoEliminada = [
            'id'             => $calificacion->id,
            'estudiante_id'  => $calificacion->estudiante_id,
            'materia_id'     => $calificacion->materia_id,
            'promedio'       => $calificacion->promedio,
            'estado'         => $calificacion->estado,
        ];

        try {
            $calificacion->delete();

            // Registro de auditoría de eliminación
            Log::warning('Calificación eliminada por administrador', [
                'user_id'      => auth()->id(),
                'datos_previos'=> $infoEliminada,
                'ip'           => request()->ip(),
                'fecha'        => now()->toDateTimeString(),
            ]);

            return redirect()
                ->route('admin.calificaciones.index')
                ->with('success', 'Registro de calificación eliminado correctamente.');
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar calificación', [
                'user_id'          => auth()->id(),
                'calificacion_id'  => $id,
                'error'            => $e->getMessage(),
                'ip'               => request()->ip(),
                'fecha'            => now()->toDateTimeString(),
            ]);

            return back()->with('error', 'No se puede eliminar esta calificación. Puede tener registros relacionados.');
        }
    }
}
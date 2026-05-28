<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequisitoCup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequisitoController extends Controller
{
    /**
     * Muestra el listado de requisitos separados por tipo.
     * Tipos: 'estudiante' y 'docente' según el examen.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cargar requisitos separados por tipo para mostrar en tabs o secciones
        $requisitosEstudiante = RequisitoCup::where('tipo', 'estudiante')
            ->orderBy('obligatorio', 'desc')
            ->orderBy('descripcion')
            ->get();
            
        $requisitosDocente = RequisitoCup::where('tipo', 'docente')
            ->orderBy('obligatorio', 'desc')
            ->orderBy('descripcion')
            ->get();
        
        return view('admin.requisitos.index', compact('requisitosEstudiante', 'requisitosDocente'));
    }

    /**
     * Almacena un nuevo requisito.
     * Puede ser para estudiantes o docentes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:500',
            'tipo'        => 'required|in:estudiante,docente',
            'obligatorio' => 'boolean',
        ], [
            'descripcion.required' => 'La descripción del requisito es obligatoria.',
            'descripcion.max'      => 'La descripción no debe exceder los 500 caracteres.',
            'tipo.required'        => 'Debe seleccionar el tipo de requisito.',
            'tipo.in'              => 'El tipo debe ser "estudiante" o "docente".',
        ]);

        $requisito = RequisitoCup::create([
            'descripcion' => $validated['descripcion'],
            'tipo'        => $validated['tipo'],
            'obligatorio' => $validated['obligatorio'] ?? false,
            'estado'      => true,
        ]);

        Log::info('Requisito creado por administrador', [
            'user_id'      => auth()->id(),
            'requisito_id' => $requisito->id,
            'tipo'         => $requisito->tipo,
            'descripcion'  => $requisito->descripcion,
            'ip'           => $request->ip(),
            'fecha'        => now()->toDateTimeString(),
        ]);

        return back()->with('success', "Requisito para {$requisito->tipo}s agregado exitosamente.");
    }

    /**
     * Actualiza un requisito existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequisitoCup  $requisito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RequisitoCup $requisito)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:500',
            'obligatorio' => 'boolean',
            'estado'      => 'boolean',
        ], [
            'descripcion.required' => 'La descripción del requisito es obligatoria.',
            'descripcion.max'      => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        $datosOriginales = $requisito->getOriginal();
        $requisito->update($validated);

        Log::info('Requisito actualizado por administrador', [
            'user_id'      => auth()->id(),
            'requisito_id' => $requisito->id,
            'cambios'      => $requisito->getChanges(),
            'ip'           => $request->ip(),
            'fecha'        => now()->toDateTimeString(),
        ]);

        return back()->with('success', 'Requisito actualizado exitosamente.');
    }

    /**
     * Elimina un requisito del sistema.
     *
     * @param  \App\Models\RequisitoCup  $requisito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RequisitoCup $requisito)
    {
        // Verificar si hay docentes o estudiantes asociados a este requisito
        $enUso = false;
        
        if ($requisito->tipo === 'docente') {
            $enUso = \App\Models\DocenteRequisito::where('requisito_id', $requisito->id)->exists();
        }
        // Puedes añadir verificación similar para estudiantes si aplica

        if ($enUso) {
            return back()->with('error', 'No se puede eliminar. Hay registros asociados a este requisito.');
        }

        $infoEliminada = [
            'id'          => $requisito->id,
            'descripcion' => $requisito->descripcion,
            'tipo'        => $requisito->tipo,
        ];

        try {
            $requisito->delete();

            Log::warning('Requisito eliminado por administrador', [
                'user_id'      => auth()->id(),
                'datos_previos'=> $infoEliminada,
                'ip'           => request()->ip(),
                'fecha'        => now()->toDateTimeString(),
            ]);

            return back()->with('success', 'Requisito eliminado exitosamente.');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar requisito', [
                'user_id'      => auth()->id(),
                'requisito_id' => $requisito->id,
                'error'        => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al eliminar el requisito.');
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\MateriaCup;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index()
    {
        $calificaciones = Calificacion::with(['estudiante', 'materia', 'registradoPor'])
            ->latest()
            ->paginate(15);
        
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();

        return view('admin.calificaciones.index', compact('calificaciones', 'estudiantes', 'materias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id' => 'required|exists:materias_cup,id',
            'nota1' => 'required|numeric|min:0|max:100',
            'nota2' => 'required|numeric|min:0|max:100',
            'nota3' => 'required|numeric|min:0|max:100',
        ]);

        // Verificar duplicado
        $existente = Calificacion::where('estudiante_id', $validated['estudiante_id'])
            ->where('materia_id', $validated['materia_id'])
            ->first();

        if ($existente) {
            return back()->with('error', 'Ya existe registro para este estudiante en esta materia.');
        }

        // Crear calificación
        $calificacion = Calificacion::create([
            'estudiante_id' => $validated['estudiante_id'],
            'materia_id' => $validated['materia_id'],
            'nota1' => $validated['nota1'],
            'nota2' => $validated['nota2'],
            'nota3' => $validated['nota3'],
            'promedio' => 0,
            'estado' => 'pendiente',
            'registrado_por' => auth()->id(),
        ]);

        // Calcular promedio y estado
        $calificacion->calcularPromedio();
        $calificacion->determinarEstado();
        $calificacion->save();

        return back()->with('success', 'Calificaciones registradas. Promedio: ' . $calificacion->promedio);
    }

    public function update(Request $request, $id)
    {
        $calificacion = Calificacion::findOrFail($id);

        $validated = $request->validate([
            'nota1' => 'required|numeric|min:0|max:100',
            'nota2' => 'required|numeric|min:0|max:100',
            'nota3' => 'required|numeric|min:0|max:100',
        ]);

        $calificacion->update($validated);
        $calificacion->calcularPromedio();
        $calificacion->determinarEstado();
        $calificacion->registrado_por = auth()->id();
        $calificacion->save();

        return back()->with('success', 'Notas actualizadas. Nuevo promedio: ' . $calificacion->promedio);
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();
        
        return back()->with('success', 'Registro de calificaciones eliminado.');
    }
    public function edit($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();

        return view('admin.calificaciones.edit', compact('calificacion', 'estudiantes', 'materias'));
    }
    public function create()
{
    $estudiantes = Estudiante::orderBy('apellidos')->get();
    $materias = MateriaCup::where('estado', true)->orderBy('orden')->get();
    return view('admin.calificaciones.create', compact('estudiantes', 'materias'));
}
}
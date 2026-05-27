<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Docente;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with('docente')
            ->withCount('inscripciones')
            ->orderBy('turno')
            ->orderBy('codigo')
            ->paginate(15);

        return view('admin.grupos.index', compact('grupos'));
    }

    public function create()
    {
        $docentes = Docente::where('estado', true)->orderBy('apellidos')->get();
        return view('admin.grupos.create', compact('docentes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:10|unique:grupos',
            'turno' => 'required|in:M,T,N',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fin' => 'required|date_format:H:i|after:horario_inicio',
            'capacidad_maxima' => 'required|integer|min:1|max:100',
            'docente_id' => 'nullable|exists:docentes,id',
        ]);

        Grupo::create($validated + ['estudiantes_inscritos' => 0, 'estado' => true]);

        return redirect()->route('admin.grupos.index')
            ->with('success', 'Grupo creado exitosamente.');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load(['docente', 'inscripciones.estudiante']);
        return view('admin.grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $docentes = Docente::where('estado', true)->orderBy('apellidos')->get();
        return view('admin.grupos.edit', compact('grupo', 'docentes'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:10|unique:grupos,codigo,' . $grupo->id,
            'turno' => 'required|in:M,T,N',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fin' => 'required|date_format:H:i|after:horario_inicio',
            'capacidad_maxima' => 'required|integer|min:1|max:100',
            'docente_id' => 'nullable|exists:docentes,id',
            'estado' => 'boolean',
        ]);

        $grupo->update($validated);

        return redirect()->route('admin.grupos.index')
            ->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy(Grupo $grupo)
    {
        if ($grupo->inscripciones()->count() > 0) {
            return back()->with('error', 'No se puede eliminar: el grupo tiene estudiantes inscritos.');
        }

        $grupo->delete();
        return redirect()->route('admin.grupos.index')
            ->with('success', 'Grupo eliminado exitosamente.');
    }
    public function calculo()
{
    $resumen = Grupo::resumenGrupos();
    $grupos = Grupo::with('docente')
        ->withCount('inscripciones')
        ->orderBy('turno')
        ->orderBy('codigo')
        ->get();
    
    return view('admin.grupos.calculo', compact('resumen', 'grupos'));
}
}
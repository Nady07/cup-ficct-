<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MateriaCup;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = MateriaCup::orderBy('orden')->paginate(10);
        return view('admin.materias.index', compact('materias'));
    }

    public function create()
    {
        return view('admin.materias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:materias_cup',
            'descripcion' => 'nullable|string',
            'nota_minima' => 'required|numeric|min:0|max:100',
            'valor_puntaje' => 'required|numeric|min:0|max:100',
            'orden' => 'required|integer|min:1',
        ]);

        MateriaCup::create($validated);

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia creada exitosamente');
    }

    public function edit(MateriaCup $materia)
    {
        return view('admin.materias.edit', compact('materia'));
    }

    public function update(Request $request, MateriaCup $materia)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:materias_cup,codigo,' . $materia->id,
            'descripcion' => 'nullable|string',
            'nota_minima' => 'required|numeric|min:0|max:100',
            'valor_puntaje' => 'required|numeric|min:0|max:100',
            'orden' => 'required|integer|min:1',
            'estado' => 'boolean',
        ]);

        $materia->update($validated);

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia actualizada exitosamente');
    }

    public function destroy(MateriaCup $materia)
    {
        $materia->delete();

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia eliminada exitosamente');
    }
}
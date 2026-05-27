<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::withCount('estudiantes')->paginate(10);
        return view('admin.carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('admin.carreras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:20|unique:carreras',
            'descripcion' => 'nullable|string',
            'duracion' => 'required|string|max:50',
            'titulo_otorgado' => 'required|string|max:255',
        ]);

        Carrera::create($validated + ['estado' => true]);

        return redirect()->route('admin.carreras.index')
            ->with('success', 'Carrera creada exitosamente.');
    }

    public function edit(Carrera $carrera)
    {
        return view('admin.carreras.edit', compact('carrera'));
    }

    public function update(Request $request, Carrera $carrera)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:20|unique:carreras,codigo,' . $carrera->id,
            'descripcion' => 'nullable|string',
            'duracion' => 'required|string|max:50',
            'titulo_otorgado' => 'required|string|max:255',
            'estado' => 'boolean',
        ]);

        $carrera->update($validated);

        return redirect()->route('admin.carreras.index')
            ->with('success', 'Carrera actualizada exitosamente.');
    }

    public function destroy(Carrera $carrera)
    {
        if ($carrera->estudiantes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar: hay estudiantes interesados en esta carrera.');
        }

        $carrera->delete();
        return redirect()->route('admin.carreras.index')
            ->with('success', 'Carrera eliminada exitosamente.');
    }
}
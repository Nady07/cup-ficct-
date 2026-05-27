<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequisitoCup;
use Illuminate\Http\Request;

class RequisitoController extends Controller
{
    public function index()
    {
        $requisitosEstudiante = RequisitoCup::where('tipo', 'estudiante')->get();
        $requisitosDocente = RequisitoCup::where('tipo', 'docente')->get();
        
        return view('admin.requisitos.index', compact('requisitosEstudiante', 'requisitosDocente'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:500',
            'tipo' => 'required|in:estudiante,docente',
            'obligatorio' => 'boolean',
        ]);

        RequisitoCup::create($validated + ['estado' => true]);

        return back()->with('success', 'Requisito agregado exitosamente.');
    }

    public function update(Request $request, RequisitoCup $requisito)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:500',
            'obligatorio' => 'boolean',
            'estado' => 'boolean',
        ]);

        $requisito->update($validated);

        return back()->with('success', 'Requisito actualizado exitosamente.');
    }

    public function destroy(RequisitoCup $requisito)
    {
        $requisito->delete();
        return back()->with('success', 'Requisito eliminado exitosamente.');
    }
}
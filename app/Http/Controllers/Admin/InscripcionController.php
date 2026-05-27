<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::with(['estudiante', 'grupo'])
            ->latest()
            ->paginate(20);

        return view('admin.inscripciones.index', compact('inscripciones'));
    }

    public function updateEstado(Request $request, Inscripcion $inscripcion)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmado,rechazado,completado',
        ]);

        $inscripcion->update(['estado' => $request->estado]);

        // Si se confirma, incrementar contador del grupo
        if ($request->estado === 'confirmado') {
            $grupo = $inscripcion->grupo;
            $grupo->increment('estudiantes_inscritos');
        }

        return back()->with('success', 'Estado de inscripción actualizado.');
    }
}
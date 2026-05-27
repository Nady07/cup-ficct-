<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
USE App\Models\RequisitoCup;
use App\Models\DocenteRequisito;

class DocenteController extends Controller
{
public function index(Request $request)
{
    $query = Docente::with('grupos')
        ->withCount('grupos')
        ->where('estado_postulacion', 'aprobado')  //  SOLO APROBADOS
        ->where('estado', true)                      //  ACTIVOS
        ->orderBy('apellidos');

    if ($request->filled('buscar')) {
        $buscar = strtolower($request->buscar);
        $query->where(function($q) use ($buscar) {
            $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$buscar}%"])
              ->orWhereRaw('LOWER(apellidos) LIKE ?', ["%{$buscar}%"])
              ->orWhere('ci', 'LIKE', "%{$buscar}%")
              ->orWhereRaw('LOWER(especialidad) LIKE ?', ["%{$buscar}%"]);
        });
    }

    $docentes = $query->paginate(10)->appends($request->query());

    return view('admin.docentes.index', compact('docentes'));
}

    public function create()
    {
        return view('admin.docentes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:docentes',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:docentes|unique:users',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:150',
            'experiencia' => 'nullable|string',
        ]);

        // Crear usuario para el docente
        $user = User::create([
            'name' => $validated['nombre'] . ' ' . $validated['apellidos'],
            'email' => $validated['email'],
            'password' => Hash::make('docente123'),
            'role' => 'docente',
        ]);

        // Crear docente
        Docente::create([
            'user_id' => $user->id,
            'ci' => $validated['ci'],
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
            'experiencia' => $validated['experiencia'] ?? null,
        ]);

        return redirect()->route('admin.docentes.index')
            ->with('success', 'Docente creado exitosamente. Contraseña por defecto: docente123');
    }

    public function show(Docente $docente)
{
    $docente->load(['grupos.inscripciones', 'user', 'requisitosPresentados.requisito']);
    
    // Obtener todos los requisitos para docentes
    $todosRequisitos = RequisitoCup::where('tipo', 'docente')->where('estado', true)->get();
    
    // Crear array con el estado de cada requisito para este docente
    $requisitosEstado = [];
    foreach ($todosRequisitos as $req) {
        $presentado = $docente->requisitosPresentados->where('requisito_id', $req->id)->first();
        $requisitosEstado[] = [
            'requisito' => $req,
            'presentado' => $presentado ? $presentado->presentado : false,
            'fecha' => $presentado ? $presentado->fecha_presentacion : null,
            'observacion' => $presentado ? $presentado->observacion : null,
            'docente_requisito_id' => $presentado ? $presentado->id : null,
        ];
    }
    
    $requisitosCompletos = collect($requisitosEstado)->where('presentado', true)->count();
    $totalRequisitos = $todosRequisitos->count();
    
    return view('admin.docentes.show', compact(
        'docente', 
        'requisitosEstado', 
        'requisitosCompletos', 
        'totalRequisitos'
    ));
}

    public function edit(Docente $docente)
    {
        return view('admin.docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:docentes,ci,' . $docente->id,
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:docentes,email,' . $docente->id . '|unique:users,email,' . $docente->user_id,
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:150',
            'experiencia' => 'nullable|string',
            'estado' => 'boolean',
        ]);

        $docente->update($validated);

        return redirect()->route('admin.docentes.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    public function destroy(Docente $docente)
    {
        if ($docente->grupos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar: el docente tiene grupos asignados.');
        }

        // Eliminar usuario asociado
        if ($docente->user) {
            $docente->user->delete();
        }

        $docente->delete();
        return redirect()->route('admin.docentes.index')
            ->with('success', 'Docente eliminado exitosamente.');
    }
    public function toggleRequisito(Docente $docente, $docenteRequisitoId)
{
    $docenteRequisito = DocenteRequisito::findOrFail($docenteRequisitoId);
    $docenteRequisito->update([
        'presentado' => !$docenteRequisito->presentado,
        'fecha_presentacion' => !$docenteRequisito->presentado ? now() : null,
    ]);
    
    return back()->with('success', 'Requisito actualizado.');
}

public function storeRequisito(Request $request, Docente $docente)
{
    $validated = $request->validate([
        'requisito_id' => 'required|exists:requisitos_cup,id',
    ]);
    
    // Verificar si ya existe
    $existente = DocenteRequisito::where('docente_id', $docente->id)
        ->where('requisito_id', $validated['requisito_id'])
        ->first();
        
    if (!$existente) {
        DocenteRequisito::create([
            'docente_id' => $docente->id,
            'requisito_id' => $validated['requisito_id'],
            'presentado' => true,
            'fecha_presentacion' => now(),
        ]);
    }
    
    return back()->with('success', 'Requisito registrado.');
}
// Cambiar estado de postulación
public function updateEstadoPostulacion(Request $request, Docente $docente)
{
    $request->validate([
        'estado_postulacion' => 'required|in:pendiente,en_revision,aprobado,rechazado',
        'motivo_rechazo' => 'required_if:estado_postulacion,rechazado|nullable|string|max:500',
    ]);

    $docente->update([
        'estado_postulacion' => $request->estado_postulacion,
        'motivo_rechazo' => $request->estado_postulacion === 'rechazado' ? $request->motivo_rechazo : null,
        'fecha_revision' => in_array($request->estado_postulacion, ['aprobado', 'rechazado']) ? now() : null,
        'revisado_por' => auth()->id(),
        'estado' => $request->estado_postulacion === 'aprobado',
    ]);

    $mensaje = match($request->estado_postulacion) {
        'aprobado' => '✅ Docente aprobado. Ya puede dar clases.',
        'rechazado' => '❌ Docente rechazado.',
        'en_revision' => '🔍 Postulación en revisión.',
        default => 'Estado actualizado.',
    };

    return back()->with('success', $mensaje);
}

// Vista de postulantes (para administrador)
public function postulantes()
{
    $docentes = Docente::withCount('requisitosPresentados as requisitos_cumplidos')
        ->withCount(['requisitosPresentados as requisitos_presentados' => function($q) {
            $q->where('presentado', true);
        }])
        ->orderBy('fecha_postulacion', 'desc')
        ->paginate(15);
    
    return view('admin.docentes.postulantes', compact('docentes'));
}
}
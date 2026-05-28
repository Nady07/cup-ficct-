<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\MateriaCup;
use App\Models\RequisitoCup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    /**
     * Dashboard del estudiante.
     * Muestra resumen de inscripciones, calificaciones y estado del CUP.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404, 'Estudiante no encontrado');
        }

        // Obtener inscripción activa con grupo y docente
        $inscripcion = Inscripcion::where('estudiante_id', $estudiante->id)
            ->with(['grupo.docente'])
            ->latest()
            ->first();

        // Obtener calificaciones con materia
        $calificaciones = Calificacion::where('estudiante_id', $estudiante->id)
            ->with('materia')
            ->get();

        // Usar los métodos del modelo (CORREGIDO)
        $promedio = $estudiante->promedio();
        $aprobadas = $estudiante->materiasAprobadas();
        $reprobadas = $estudiante->materiasReprobadas();
        $aproboCUP = $estudiante->aproboCUP();

        return view('estudiante.dashboard', compact(
            'estudiante',
            'inscripcion',
            'calificaciones',
            'promedio',
            'aprobadas',
            'reprobadas',
            'aproboCUP'
        ));
    }

    /**
     * Muestra el horario del estudiante según su grupo asignado.
     *
     * @return \Illuminate\View\View
     */
    public function horario()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        // Obtener el grupo del estudiante a través de la inscripción
        $inscripcion = Inscripcion::where('estudiante_id', $estudiante->id)
            ->where('estado', 'confirmado')
            ->with('grupo.docente')
            ->first();

        $grupo = $inscripcion ? $inscripcion->grupo : null;

        return view('estudiante.horario', compact('grupo', 'inscripcion'));
    }

    /**
     * Muestra las calificaciones del estudiante.
     *
     * @return \Illuminate\View\View
     */
    public function calificaciones()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            abort(404);
        }

        $calificaciones = Calificacion::where('estudiante_id', $estudiante->id)
            ->with('materia')
            ->get();

        $promedio = $estudiante->promedio();
        $aprobadas = $estudiante->materiasAprobadas();
        $reprobadas = $estudiante->materiasReprobadas();
        $aproboCUP = $estudiante->aproboCUP();

        return view('estudiante.calificaciones', compact(
            'calificaciones',
            'promedio',
            'aprobadas',
            'reprobadas',
            'aproboCUP'
        ));
    }

    /**
     * Muestra los docentes asignados al grupo del estudiante.
     *
     * @return \Illuminate\View\View
     */
    public function docentes()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('user_id', auth()->id())
        ->with(['carreraInteres', 'carreraOpcion2', 'inscripcion.grupo', 'calificaciones.materia'])
        ->first();
        if (!$estudiante) {
            abort(404);
        }

        // Obtener docente del grupo del estudiante
        $inscripcion = Inscripcion::where('estudiante_id', $estudiante->id)
            ->where('estado', 'confirmado')
            ->with('grupo.docente')
            ->first();

        $docente = $inscripcion ? $inscripcion->grupo->docente : null;

        return view('estudiante.docentes', compact('docente'));
    }

    /**
     * Muestra información del CUP (materias y requisitos).
     *
     * @return \Illuminate\View\View
     */
    public function cup()
    {
        $materiasCup = MateriaCup::where('estado', true)
            ->orderBy('orden')
            ->get();

        $requisitos = RequisitoCup::where('tipo', 'estudiante')
            ->where('estado', true)
            ->orderBy('obligatorio', 'desc')
            ->get();

        return view('estudiante.cup-info', compact('materiasCup', 'requisitos'));
    }
public function uploadRequisito(Request $request)
{
    $request->validate([
        'requisito_id' => 'required|exists:requisitos_cup,id',
        'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $estudiante = auth()->user()->estudiante;
    
    // Guardar archivo
    $path = $request->file('archivo')->store('requisitos/' . $estudiante->id, 'public');

    // Marcar que subió al menos un documento (pendiente de revisión)
    $estudiante->update([
        'requisitos_completos' => false, // Aún no aprobado, solo subido
        'estado_flujo' => 'postulante', // Se mantiene como postulante hasta que admin apruebe
    ]);

    return back()->with('success', 'Documento subido correctamente. Pendiente de revisión.');
}
public function updatePerfil(Request $request)
{
    $estudiante = auth()->user()->estudiante;
    
    $validated = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellidos' => 'nullable|string|max:100',
        'ci' => 'required|string|max:20|unique:estudiantes,ci,' . $estudiante->id,
        'fecha_nacimiento' => 'required|date',
        'sexo' => 'nullable|in:M,F,O',
        'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:500',
        'ciudad' => 'nullable|string|max:100',
        'colegio_procedencia' => 'required|string|max:200',
        'anio_graduacion' => 'required|integer|min:2000|max:2030',
        'carrera_interes_id' => 'required|exists:carreras,id',
        'carrera_opcion2_id' => 'nullable|exists:carreras,id',
        'modalidad' => 'nullable|in:presencial,virtual,hibrido',
        'es_extranjero' => 'nullable|boolean',
        'documento_extranjero' => 'nullable|string|max:50',
        'password_actual' => 'nullable|string',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Cambiar contraseña si se proporcionó
    if ($request->filled('password_actual')) {
        if (!Hash::check($request->password_actual, auth()->user()->password)) {
            return back()->with('error', 'La contraseña actual es incorrecta.');
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);
        unset($validated['password_actual'], $validated['password'], $validated['password_confirmation']);
    } else {
        unset($validated['password_actual'], $validated['password'], $validated['password_confirmation']);
    }

    $estudiante->update($validated);

    return back()->with('success', 'Perfil actualizado correctamente.');
}
public function uploadPago(Request $request)
{
    $request->validate([
        'comprobante' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $estudiante = auth()->user()->estudiante;
    $path = $request->file('comprobante')->store('pagos/' . $estudiante->id, 'public');

    $estudiante->update([
        'comprobante_pago_path' => $path,
        'estado_flujo' => 'pago_confirmado',
        'fecha_pago' => now(),
    ]);

    return back()->with('success', 'Comprobante de pago subido correctamente. Espera la confirmación del administrador.');
}

public function pago()
{
    $estudiante = auth()->user()->estudiante;
    $config = \App\Models\ConfiguracionPago::getActiva();
    
    return view('estudiante.pago', compact('estudiante', 'config'));
}
}
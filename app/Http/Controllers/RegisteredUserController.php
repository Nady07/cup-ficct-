<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Docente;
use App\Models\Estudiante;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:estudiante,docente'],
            'ci' => ['required', 'string', 'max:20', 'unique:estudiantes,ci'],
            'fecha_nacimiento' => ['required', 'date'],
            'sexo' => ['nullable', 'in:M,F,O'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'colegio_procedencia' => ['required', 'string', 'max:200'],
            'anio_graduacion' => ['required', 'integer', 'min:2000', 'max:2030'],
            'carrera_interes_id' => ['required', 'exists:carreras,id'],
            'carrera_opcion2_id' => ['nullable', 'exists:carreras,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'estudiante') {
            Estudiante::create([
                'user_id' => $user->id,
                'ci' => $request->ci,
                'nombre' => $request->name,
                'apellidos' => '',
                'email' => $request->email,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'sexo' => $request->sexo,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'colegio_procedencia' => $request->colegio_procedencia,
                'anio_graduacion' => $request->anio_graduacion,
                'carrera_interes_id' => $request->carrera_interes_id,
                'carrera_opcion2_id' => $request->carrera_opcion2_id,
                'estado_flujo' => 'postulante',
                'estado' => true,
            ]);
        } elseif ($request->role === 'docente') {
            Docente::create([
                'user_id' => $user->id,
                'ci' => $request->ci,
                'nombre' => $request->name,
                'apellidos' => '',
                'email' => $request->email,
                'estado_postulacion' => 'pendiente',
                'estado' => true,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route(
            $request->role === 'estudiante' ? 'estudiante.dashboard' : 'docente.dashboard'
        );
    }
}
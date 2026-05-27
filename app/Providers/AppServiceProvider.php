<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Crear directorios necesarios para vistas del admin
        $baseDir = resource_path('views/admin');
        $dirs = [
            'grupos', 'docentes', 'carreras', 'requisitos', 
            'estudiantes', 'inscripciones', 'calificaciones'
        ];

        foreach ($dirs as $dir) {
            $path = "$baseDir/$dir";
            if (!is_dir($path)) {
                @mkdir($path, 0777, true);
            }
        }

        // Generar vistas si no existen
        $this->generateViewsIfNotExist();
    }

    /**
     * Generar vistas admin automáticamente
     */
    private function generateViewsIfNotExist()
    {
        $baseDir = resource_path('views/admin');

        // Grupos index
        if (!file_exists("$baseDir/grupos/index.blade.php")) {
            file_put_contents("$baseDir/grupos/index.blade.php", $this->getGruposIndexView());
        }
        if (!file_exists("$baseDir/grupos/create.blade.php")) {
            file_put_contents("$baseDir/grupos/create.blade.php", $this->getGruposCreateView());
        }
        if (!file_exists("$baseDir/grupos/edit.blade.php")) {
            file_put_contents("$baseDir/grupos/edit.blade.php", $this->getGruposEditView());
        }
        if (!file_exists("$baseDir/grupos/show.blade.php")) {
            file_put_contents("$baseDir/grupos/show.blade.php", $this->getGruposShowView());
        }

        // Docentes
        if (!file_exists("$baseDir/docentes/index.blade.php")) {
            file_put_contents("$baseDir/docentes/index.blade.php", $this->getDocentesIndexView());
        }
        if (!file_exists("$baseDir/docentes/create.blade.php")) {
            file_put_contents("$baseDir/docentes/create.blade.php", $this->getDocentesCreateView());
        }
        if (!file_exists("$baseDir/docentes/edit.blade.php")) {
            file_put_contents("$baseDir/docentes/edit.blade.php", $this->getDocentesEditView());
        }

        // Carreras
        if (!file_exists("$baseDir/carreras/index.blade.php")) {
            file_put_contents("$baseDir/carreras/index.blade.php", $this->getCarrerasIndexView());
        }
    }

    private function getGruposIndexView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Grupos')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Grupos Académicos</h1>
            <p class="text-gray-600 dark:text-gray-400">Administra los grupos</p>
        </div>
        <a href="{{ route('admin.grupos.create') }}" class="inline-flex items-center space-x-2 bg-ficct-blue hover:bg-ficct-light-blue text-white px-6 py-3 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            <span>Nuevo</span>
        </a>
    </div>
    @forelse($grupos as $g)
        <div class="bg-white dark:bg-dark-surface p-6 rounded-lg hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-bold text-lg">{{ $g->codigo }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $g->horario_inicio }} - {{ $g->horario_fin }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.grupos.edit', $g) }}" class="text-blue-600 hover:text-blue-800"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg></a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center py-12 text-gray-500">Sin grupos</p>
    @endforelse
</div>
@endsection
BLADE; }

    private function getGruposCreateView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Nuevo Grupo')
@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.grupos.index') }}" class="text-ficct-blue mb-6 inline-block">← Volver</a>
    <div class="bg-white dark:bg-dark-surface p-8 rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Crear Grupo</h1>
        <form action="{{ route('admin.grupos.store') }}" method="POST" class="space-y-4">
            @csrf
            <div><label class="block font-medium mb-1">Código</label><input type="text" name="codigo" class="w-full border rounded p-2 dark:bg-dark-bg" required></div>
            <div><label class="block font-medium mb-1">Turno</label><select name="turno" class="w-full border rounded p-2 dark:bg-dark-bg" required><option value="M">Mañana</option><option value="T">Tarde</option><option value="N">Noche</option></select></div>
            <button type="submit" class="w-full bg-ficct-blue text-white py-2 rounded hover:bg-ficct-light-blue">Guardar</button>
        </form>
    </div>
</div>
@endsection
BLADE; }

    private function getGruposEditView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Editar Grupo')
@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.grupos.index') }}" class="text-ficct-blue mb-6 inline-block">← Volver</a>
    <div class="bg-white dark:bg-dark-surface p-8 rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Editar: {{ $grupo->codigo }}</h1>
        <form action="{{ route('admin.grupos.update', $grupo) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div><label class="block font-medium mb-1">Código</label><input type="text" name="codigo" value="{{ $grupo->codigo }}" class="w-full border rounded p-2 dark:bg-dark-bg" required></div>
            <button type="submit" class="w-full bg-ficct-blue text-white py-2 rounded hover:bg-ficct-light-blue">Actualizar</button>
        </form>
    </div>
</div>
@endsection
BLADE; }

    private function getGruposShowView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', $grupo->codigo)
@section('content')
<a href="{{ route('admin.grupos.index') }}" class="text-ficct-blue mb-6 inline-block">← Volver</a>
<div class="bg-white dark:bg-dark-surface p-8 rounded-lg"><h1 class="text-2xl font-bold mb-4">{{ $grupo->codigo }}</h1></div>
@endsection
BLADE; }

    private function getDocentesIndexView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Docentes')
@section('content')
<div class="space-y-6"><h1 class="text-3xl font-bold">Docentes</h1>@forelse($docentes as $d)<div class="bg-white dark:bg-dark-surface p-6 rounded-lg"><h3 class="font-bold">{{ $d->nombre }}</h3></div>@empty<p class="text-center py-12">Sin docentes</p>@endforelse</div>
@endsection
BLADE; }

    private function getDocentesCreateView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Nuevo Docente')
@section('content')
<div class="max-w-2xl mx-auto"><a href="{{ route('admin.docentes.index') }}" class="text-ficct-blue mb-6 inline-block">← Volver</a><div class="bg-white dark:bg-dark-surface p-8 rounded-lg"><h1 class="text-2xl font-bold mb-6">Crear Docente</h1></div></div>
@endsection
BLADE; }

    private function getDocentesEditView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Editar Docente')
@section('content')
<a href="{{ route('admin.docentes.index') }}" class="text-ficct-blue mb-6 inline-block">← Volver</a>
@endsection
BLADE; }

    private function getCarrerasIndexView() { return <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Carreras')
@section('content')
<h1 class="text-3xl font-bold mb-6">Carreras</h1>
@endsection
BLADE; }
}

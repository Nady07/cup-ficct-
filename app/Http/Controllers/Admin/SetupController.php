<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Helper para setup de vistas admin
 */
class SetupController extends Controller
{
    public function createViews()
    {
        $viewsDir = resource_path('views/admin');

        // Crear vistas de grupos
        $gruposIndex = <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Grupos')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Gestión de Grupos</h1>
            <p class="text-gray-600 dark:text-gray-400">Administra los grupos académicos</p>
        </div>
        <a href="{{ route('admin.grupos.create') }}" class="inline-flex items-center space-x-2 bg-ficct-blue hover:bg-ficct-light-blue text-white px-6 py-3 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            <span>Nuevo</span>
        </a>
    </div>
    @forelse($grupos as $grupo)
        <div class="bg-white dark:bg-dark-surface p-6 rounded-lg">
            <h3 class="font-bold">{{ $grupo->codigo }}</h3>
            <p>{{ $grupo->horario_inicio }} - {{ $grupo->horario_fin }}</p>
        </div>
    @empty
        <p>Sin grupos</p>
    @endforelse
</div>
@endsection
BLADE;

        file_put_contents("{$viewsDir}/grupos/index.blade.php", $gruposIndex);

        return response()->json(['success' => true, 'message' => 'Vistas creadas']);
    }
}

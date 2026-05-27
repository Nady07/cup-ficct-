@extends('layouts.admin')

@section('title', 'Nuevo Docente')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.docentes.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a docentes
        </a>
    </div>

    <div class="card">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Registrar Nuevo Docente
        </h2>

        <form action="{{ route('admin.docentes.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Apellidos *</label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">CI *</label>
                    <input type="text" name="ci" value="{{ old('ci') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="input-ficct">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Especialidad</label>
                    <input type="text" name="especialidad" value="{{ old('especialidad') }}" class="input-ficct">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Experiencia</label>
                    <textarea name="experiencia" rows="3" class="input-ficct">{{ old('experiencia') }}</textarea>
                </div>
            </div>
            <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900 dark:bg-opacity-20 rounded-lg">
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Se creará automáticamente un usuario para el docente con contraseña por defecto: <strong>docente123</strong>
                </p>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar Docente
                </button>
                <a href="{{ route('admin.docentes.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
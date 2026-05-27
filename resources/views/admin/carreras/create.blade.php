@extends('layouts.admin')

@section('title', 'Nueva Carrera')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.carreras.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a carreras
        </a>
    </div>

    <div class="card">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Registrar Nueva Carrera
        </h2>

        <form action="{{ route('admin.carreras.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Ingeniería Informática" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: INF" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Duración *</label>
                    <input type="text" name="duracion" value="{{ old('duracion', '5 años') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Título Otorgado *</label>
                    <input type="text" name="titulo_otorgado" value="{{ old('titulo_otorgado') }}" placeholder="Ej: Ingeniero Informático" class="input-ficct" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="input-ficct" placeholder="Describe la carrera...">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar Carrera
                </button>
                <a href="{{ route('admin.carreras.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
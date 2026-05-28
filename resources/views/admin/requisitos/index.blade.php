@extends('layouts.admin')

@section('title', 'Requisitos')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Requisitos</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ $requisitosEstudiante->count() }} estudiante · {{ $requisitosDocente->count() }} docente
            </p>
        </div>
    </div>

    {{-- Grid 2 columnas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Requisitos Estudiante --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">📝 Para Estudiantes</h2>
                <button onclick="agregarRequisito('estudiante')" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    + Agregar
                </button>
            </div>
            <div class="p-4">
                @if($requisitosEstudiante->count() > 0)
                    <div class="space-y-2">
                        @foreach($requisitosEstudiante as $req)
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-800/50 rounded text-xs">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $req->descripcion }}</span>
                                <x-badge :color="$req->obligatorio ? 'red' : 'gray'">
                                    {{ $req->obligatorio ? 'Obligatorio' : 'Opcional' }}
                                </x-badge>
                            </div>
                            <x-btn-icon title="Editar" color="blue" onclick="editarRequisito({{ $req->id }}, '{{ $req->descripcion }}', {{ $req->obligatorio ? 'true' : 'false' }})">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </x-btn-icon>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-gray-400 text-center py-4">No hay requisitos definidos</p>
                @endif
            </div>
        </div>

        {{-- Requisitos Docente --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">👨‍🏫 Para Docentes</h2>
                <button onclick="agregarRequisito('docente')" class="text-xs text-purple-600 hover:text-purple-800 dark:text-purple-400">
                    + Agregar
                </button>
            </div>
            <div class="p-4">
                @if($requisitosDocente->count() > 0)
                    <div class="space-y-2">
                        @foreach($requisitosDocente as $req)
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-800/50 rounded text-xs">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $req->descripcion }}</span>
                                <x-badge :color="$req->obligatorio ? 'red' : 'gray'">
                                    {{ $req->obligatorio ? 'Obligatorio' : 'Opcional' }}
                                </x-badge>
                            </div>
                            <x-btn-icon title="Editar" color="blue" onclick="editarRequisito({{ $req->id }}, '{{ $req->descripcion }}', {{ $req->obligatorio ? 'true' : 'false' }})">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </x-btn-icon>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-gray-400 text-center py-4">No hay requisitos definidos</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<x-modal name="modal-requisito" maxWidth="sm">
    <div class="p-5">
        <h3 id="modalTitle" class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Requisito</h3>
        <form id="formRequisito" method="POST" class="space-y-3">
            @csrf
            <div id="methodField"></div>
            <input type="hidden" id="tipoRequisito" name="tipo">
            <div>
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Descripción *</label>
                <input type="text" id="descRequisito" name="descripcion" class="input-ficct text-xs" required>
            </div>
            <label class="flex items-center gap-2 text-xs">
                <input type="checkbox" id="oblRequisito" name="obligatorio" value="1" checked>
                Obligatorio
            </label>
            <div class="flex gap-2 justify-end pt-2 border-t border-gray-200 dark:border-gray-700">
                <button type="button" @click="$dispatch('close-modal', 'modal-requisito')" class="btn-secondary text-xs px-3 py-1.5">Cancelar</button>
                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Guardar</button>
            </div>
        </form>
    </div>
</x-modal>

<script>
    function agregarRequisito(tipo) {
        document.getElementById('modalTitle').textContent = 'Nuevo Requisito';
        document.getElementById('formRequisito').action = '{{ route("admin.requisitos.store") }}';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('tipoRequisito').value = tipo;
        document.getElementById('descRequisito').value = '';
        document.getElementById('oblRequisito').checked = true;
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modal-requisito' }));
    }
    function editarRequisito(id, desc, obl) {
        document.getElementById('modalTitle').textContent = 'Editar Requisito';
        document.getElementById('formRequisito').action = '/admin/requisitos/' + id;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('descRequisito').value = desc;
        document.getElementById('oblRequisito').checked = obl;
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modal-requisito' }));
    }
</script>
@endsection
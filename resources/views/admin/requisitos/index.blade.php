@extends('layouts.admin')

@section('title', 'Gestión de Requisitos')

@section('content')
<div class="animate-fade-in">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Requisitos del CUP
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Requisitos Estudiante -->
        <div class="card">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Para Estudiantes
            </h3>
            <ul class="space-y-3">
                @foreach($requisitosEstudiante as $req)
                <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-dark-surface rounded-lg">
                    <span class="text-green-500 mt-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span>{{ $req->descripcion }}</span>
                        <span class="ml-2 px-2 py-0.5 text-xs rounded {{ $req->obligatorio ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $req->obligatorio ? 'Obligatorio' : 'Opcional' }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="editarRequisito({{ $req->id }}, '{{ $req->descripcion }}', {{ $req->obligatorio }})" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                    </div>
                </li>
                @endforeach
            </ul>
            <button onclick="agregarRequisito('estudiante')" class="mt-4 text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar requisito
            </button>
        </div>

        <!-- Requisitos Docente -->
        <div class="card">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Para Docentes
            </h3>
            <ul class="space-y-3">
                @foreach($requisitosDocente as $req)
                <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-dark-surface rounded-lg">
                    <span class="text-purple-500 mt-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span>{{ $req->descripcion }}</span>
                        <span class="ml-2 px-2 py-0.5 text-xs rounded {{ $req->obligatorio ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $req->obligatorio ? 'Obligatorio' : 'Opcional' }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="editarRequisito({{ $req->id }}, '{{ $req->descripcion }}', {{ $req->obligatorio }})" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                    </div>
                </li>
                @endforeach
            </ul>
            <button onclick="agregarRequisito('docente')" class="mt-4 text-purple-600 hover:text-purple-800 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar requisito
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalRequisito" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-dark-surface rounded-lg p-6 w-full max-w-md animate-fade-in">
        <h3 id="modalTitle" class="text-lg font-bold mb-4">Requisito</h3>
        <form id="formRequisito" method="POST">
            @csrf
            <div id="methodField"></div>
            <input type="hidden" id="tipoRequisito" name="tipo">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Descripción *</label>
                <input type="text" id="descRequisito" name="descripcion" class="input-ficct" required>
            </div>
            <div class="mb-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="oblRequisito" name="obligatorio" value="1" checked>
                    <span class="text-sm">Obligatorio</span>
                </label>
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="cerrarModalReq()" class="btn-secondary">Cancelar</button>
                <button type="submit" class="btn-primary">💾 Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function agregarRequisito(tipo) {
        document.getElementById('modalTitle').textContent = 'Nuevo Requisito';
        document.getElementById('formRequisito').action = '{{ route("admin.requisitos.store") }}';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('tipoRequisito').value = tipo;
        document.getElementById('descRequisito').value = '';
        document.getElementById('oblRequisito').checked = true;
        document.getElementById('modalRequisito').classList.remove('hidden');
    }

    function editarRequisito(id, desc, obl) {
        document.getElementById('modalTitle').textContent = 'Editar Requisito';
        document.getElementById('formRequisito').action = '/admin/requisitos/' + id;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('tipoRequisito').value = '';
        document.getElementById('descRequisito').value = desc;
        document.getElementById('oblRequisito').checked = obl;
        document.getElementById('modalRequisito').classList.remove('hidden');
    }

    function cerrarModalReq() {
        document.getElementById('modalRequisito').classList.add('hidden');
    }
</script>
@endsection
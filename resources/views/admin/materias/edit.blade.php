<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Materia: ') . $materia->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.materias.update', $materia) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Código</label>
                            <input type="text" name="codigo" value="{{ old('codigo', $materia->codigo) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nota Mínima</label>
                            <input type="number" name="nota_minima" value="{{ old('nota_minima', $materia->nota_minima) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor Puntaje</label>
                            <input type="number" name="valor_puntaje" value="{{ old('valor_puntaje', $materia->valor_puntaje) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Orden</label>
                            <input type="number" name="orden" value="{{ old('orden', $materia->orden) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="1" {{ $materia->estado ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ !$materia->estado ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Actualizar
                        </button>
                        <a href="{{ route('admin.materias.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
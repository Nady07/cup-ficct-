<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Materias del CUP') }}
            </h2>
            <a href="{{ route('admin.materias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nueva Materia
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nota Mín</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Puntaje</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($materias as $materia)
                        <tr>
                            <td class="px-6 py-4">{{ $materia->orden }}</td>
                            <td class="px-6 py-4">{{ $materia->codigo }}</td>
                            <td class="px-6 py-4">{{ $materia->nombre }}</td>
                            <td class="px-6 py-4">{{ $materia->nota_minima }}</td>
                            <td class="px-6 py-4">{{ $materia->valor_puntaje }} pts</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded {{ $materia->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $materia->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.materias.edit', $materia) }}" class="text-blue-600 hover:text-blue-900 mr-2">Editar</a>
                                <form action="{{ route('admin.materias.destroy', $materia) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar esta materia?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $materias->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
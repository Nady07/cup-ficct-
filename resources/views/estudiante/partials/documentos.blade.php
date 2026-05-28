@php $e = auth()->user()->estudiante; $requisitos = \App\Models\RequisitoCup::where('tipo', 'estudiante')->where('estado', true)->orderBy('obligatorio', 'desc')->get(); @endphp

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Documentos</h3>
        <x-badge :color="$e->requisitos_completos ? 'green' : 'yellow'">{{ $e->requisitos_completos ? 'Completos' : 'Pendientes' }}</x-badge>
    </div>
    <div class="p-5">
        @if($requisitos->count() > 0)
            <div class="space-y-2 mb-4">
                @foreach($requisitos as $req)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl text-xs">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <svg class="w-4 h-4 flex-shrink-0 {{ $e->requisitos_completos ? 'text-green-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="flex-1 truncate">{{ $req->descripcion }}</span>
                            <span class="text-[10px] {{ $req->obligatorio ? 'text-red-500 font-medium' : 'text-gray-400' }}">{{ $req->obligatorio ? 'Obligatorio' : 'Opcional' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(!$e->requisitos_completos)
                <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
                    <h4 class="text-xs font-semibold text-gray-900 dark:text-white mb-3">Subir Documento</h4>
                    <form action="{{ route('estudiante.requisitos.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <select name="requisito_id" class="input-ficct text-xs" required>
                            <option value="">Seleccionar documento...</option>
                            @foreach($requisitos as $req)
                                <option value="{{ $req->id }}">{{ $req->descripcion }}</option>
                            @endforeach
                        </select>
                        <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png" required
                               class="w-full text-xs file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-950/30 dark:file:text-blue-300 file:cursor-pointer">
                        <p class="text-[10px] text-gray-400">Formatos: PDF, JPG, PNG (máx. 2MB)</p>
                        <button type="submit" class="btn-primary text-xs px-4 py-2 w-full">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Subir documento
                        </button>
                    </form>
                </div>
            @endif
        @else
            <p class="text-xs text-gray-400 text-center py-4">No hay requisitos definidos.</p>
        @endif
    </div>
</div>
@php $e = auth()->user()->estudiante; @endphp

@if($e->requisitosEnviados && $e->requisitosEnviados->count() > 0)
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Documentos Enviados</h3>
    </div>
    <div class="p-5">
        <div class="space-y-3">
            @foreach($e->requisitosEnviados as $enviado)
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/30 rounded-xl border text-xs">
                    <div class="flex items-center gap-3">
                        @if($enviado->aprobado)
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-green-600">Aprobado</span>
                        @elseif($enviado->presentado)
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-blue-600">En revisión</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500">{{ $enviado->requisito->descripcion ?? 'Documento' }}</span>
                        <span class="text-[10px] text-gray-400">{{ $enviado->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
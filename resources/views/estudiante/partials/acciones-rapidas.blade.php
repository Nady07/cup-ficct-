@php $e = auth()->user()->estudiante; $flujo = $e->estado_flujo ?? 'postulante'; @endphp

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h3>
    <div class="space-y-2">
        @if($flujo === 'postulante')
            <a href="#" class="flex items-center gap-3 p-3 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800 rounded-xl text-xs hover:shadow-md transition-all">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <div><p class="font-medium">Subir documentos</p><p class="text-gray-400 text-[10px]">PDF, JPG, PNG</p></div>
            </a>
        @elseif($flujo === 'requisitos_aprobados')
            <a href="{{ route('estudiante.pago') }}" class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-800 rounded-xl text-xs hover:shadow-md transition-all">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <div><p class="font-medium">Realizar pago</p><p class="text-gray-400 text-[10px]">Ver datos bancarios</p></div>
            </a>
        @elseif(in_array($flujo, ['inscrito', 'cup_aprobado']))
            <a href="{{ route('estudiante.calificaciones') }}" class="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-950/20 border border-purple-200 dark:border-purple-800 rounded-xl text-xs hover:shadow-md transition-all">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <div><p class="font-medium">Ver calificaciones</p><p class="text-gray-400 text-[10px]">Revisa tus notas</p></div>
            </a>
        @endif
    </div>
</div>
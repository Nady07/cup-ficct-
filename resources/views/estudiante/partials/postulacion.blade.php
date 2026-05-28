@php $e = auth()->user()->estudiante; @endphp

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Mi Postulación</h3>
        <span class="text-[10px] text-gray-400">{{ $e->ci ?? '—' }}</span>
    </div>
    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-3">
                <h4 class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Académico</h4>
                <div class="bg-slate-50 dark:bg-slate-900/30 rounded-xl p-4 border border-slate-200 dark:border-slate-800">
                    <p class="text-sm font-semibold">{{ $e->carreraInteres->nombre ?? 'No definida' }}</p>
                    <p class="text-[10px] text-gray-500">{{ $e->carreraInteres->codigo ?? '—' }} · {{ $e->carreraInteres->duracion ?? '—' }}</p>
                    @if($e->carreraOpcion2)
                    <div class="mt-2 flex items-center gap-2 text-[10px] text-gray-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        <span>2ª opción: <span class="font-medium">{{ $e->carreraOpcion2->nombre ?? '—' }}</span></span>
                    </div>
                    @endif
                </div>
                <div class="bg-slate-50 dark:bg-slate-900/30 rounded-xl p-4 border border-slate-200 dark:border-slate-800">
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Colegio</p>
                    <p class="text-sm font-medium">{{ $e->colegio_procedencia ?: '—' }}</p>
                    <p class="text-[10px] text-gray-500">Promoción {{ $e->anio_graduacion ?: '—' }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <h4 class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Personal</h4>
                <div class="space-y-2">
                    @foreach([['label'=>'Email','value'=>$e->email],['label'=>'Teléfono','value'=>$e->telefono?:'—'],['label'=>'Dirección','value'=>$e->direccion?:'—'],['label'=>'Nacimiento','value'=>$e->fecha_nacimiento?->format('d/m/Y')?:'—']] as $d)
                    <div class="flex justify-between py-2 px-3 bg-slate-50 dark:bg-slate-900/30 rounded-lg text-xs">
                        <span class="text-gray-500">{{ $d['label'] }}</span>
                        <span class="font-medium">{{ $d['value'] }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100 dark:border-gray-800">
                    <x-badge :color="$e->modalidad === 'virtual' ? 'blue' : ($e->modalidad === 'hibrido' ? 'purple' : 'green')">
                        {{ ucfirst($e->modalidad ?? 'Presencial') }}
                    </x-badge>
                    @if($e->es_extranjero)
                        <x-badge color="yellow">Extranjero</x-badge>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
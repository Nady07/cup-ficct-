@php $e = auth()->user()->estudiante; $flujo = $e->estado_flujo ?? 'postulante'; @endphp

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-5">Progreso de Postulación</h3>
    @php
        $timeline = [
            ['key' => 'postulante', 'label' => 'Registro', 'date' => $e->created_at],
            ['key' => 'requisitos_aprobados', 'label' => 'Requisitos', 'date' => $e->fecha_aprobacion_requisitos],
            ['key' => 'pago_confirmado', 'label' => 'Pago', 'date' => $e->fecha_pago],
            ['key' => 'inscrito', 'label' => 'Inscripción', 'date' => $e->inscripcion->fecha_inscripcion ?? null],
            ['key' => 'cup_aprobado', 'label' => 'CUP', 'date' => null],
        ];
        $currentIndex = array_search($flujo, array_column($timeline, 'key')) ?: 0;
    @endphp
    <div class="relative flex items-center justify-between">
        <div class="absolute top-4 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
        <div class="absolute top-4 left-0 h-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full transition-all duration-1000" 
             style="width: {{ ($currentIndex / (count($timeline) - 1)) * 100 }}%"></div>
        @foreach($timeline as $i => $item)
            @php $isCompleted = $currentIndex >= $i; $isCurrent = $flujo === $item['key']; @endphp
            <div class="relative flex flex-col items-center group">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold z-10 transition-all duration-500
                    {{ $isCompleted ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}
                    {{ $isCurrent ? 'ring-4 ring-green-300/50 dark:ring-green-700/50' : '' }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $i + 1 }}
                    @endif
                </div>
                <p class="text-[10px] mt-2 font-semibold {{ $isCompleted ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}">{{ $item['label'] }}</p>
                @if($item['date'] && $isCompleted)
                    <p class="text-[9px] text-gray-400">{{ \Carbon\Carbon::parse($item['date'])->format('d/m') }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
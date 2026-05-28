@php $e = auth()->user()->estudiante; $flujo = $e->estado_flujo ?? 'postulante'; @endphp

<div class="relative overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 rounded-2xl p-6 sm:p-8 text-white shadow-2xl shadow-slate-500/10">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/3 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-1/4 w-48 h-48 bg-white/3 rounded-full translate-y-1/2"></div>
    <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-slate-400 text-sm mb-1">Bienvenido de vuelta</p>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ auth()->user()->name }}</h1>
            <div class="flex flex-wrap items-center gap-3 mt-3">
                <x-badge :color="match($flujo){'postulante'=>'yellow','requisitos_aprobados'=>'blue','pago_confirmado'=>'green','inscrito'=>'green','cup_aprobado'=>'green',default=>'gray'}">
                    {{ ucfirst(str_replace('_', ' ', $flujo)) }}
                </x-badge>
                <span class="text-slate-400 text-xs">CI: {{ $e->ci ?? '—' }}</span>
                <span class="text-slate-500">·</span>
                <span class="text-slate-400 text-xs">{{ $e->carreraInteres->nombre ?? 'Sin carrera' }}</span>
            </div>
        </div>
        <button @click="$dispatch('open-modal', 'editar-perfil')" 
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl text-sm font-medium transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar perfil
        </button>
    </div>
</div>
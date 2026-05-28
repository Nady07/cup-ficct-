@php $e = auth()->user()->estudiante; @endphp

@if($e->estado_flujo === 'requisitos_aprobados' || $e->estado_flujo === 'pago_confirmado')
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Información de Pago</h3>
    </div>
    <div class="p-5">
        @php $config = \App\Models\ConfiguracionPago::getActiva(); @endphp
        
        @if($config)
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 rounded-xl p-4 border border-green-200 dark:border-green-800 mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Monto a pagar</p>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-300">
                            Bs. {{ $e->es_extranjero ? number_format($config->precio_extranjero, 2) : number_format($config->precio_nacional, 2) }}
                        </p>
                    </div>
                    <x-badge :color="$e->es_extranjero ? 'yellow' : 'green'">{{ $e->es_extranjero ? 'Extranjero' : 'Nacional' }}</x-badge>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                <div class="p-3 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                    <p class="text-[10px] text-gray-400 uppercase">Banco</p>
                    <p class="text-sm font-medium">{{ $config->banco }}</p>
                </div>
                <div class="p-3 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                    <p class="text-[10px] text-gray-400 uppercase">N° Cuenta</p>
                    <p class="text-sm font-mono font-medium">{{ $config->cuenta }}</p>
                </div>
            </div>

            @if($config->qr_path)
                <div class="text-center mb-4 p-4 bg-white dark:bg-gray-800 rounded-xl border">
                    <img src="{{ asset('storage/' . $config->qr_path) }}" alt="QR de Pago" class="mx-auto w-40 h-40 object-contain">
                </div>
            @endif

            @if($e->estado_flujo === 'requisitos_aprobados')
                <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
                    <h4 class="text-xs font-semibold mb-3">Subir Comprobante</h4>
                    <form action="{{ route('estudiante.pago.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <input type="file" name="comprobante" accept=".pdf,.jpg,.jpeg,.png" required
                               class="w-full text-xs file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-950/30 dark:file:text-green-300 file:cursor-pointer">
                        <button type="submit" class="btn-primary text-xs px-4 py-2 w-full bg-green-600 hover:bg-green-700">Subir comprobante</button>
                    </form>
                </div>
            @endif

            @if($e->estado_flujo === 'pago_confirmado')
                <div class="bg-green-50 dark:bg-green-950/20 rounded-xl p-4 border border-green-200 dark:border-green-800 text-center">
                    <svg class="w-8 h-8 mx-auto text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-semibold text-green-700 dark:text-green-300">Pago confirmado</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endif
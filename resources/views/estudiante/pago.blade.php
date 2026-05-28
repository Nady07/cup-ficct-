@extends('layouts.estudiante')

@section('title', 'Realizar Pago')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    {{-- Header --}}
    <div>
        <a href="{{ route('estudiante.dashboard') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver al dashboard
        </a>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Realizar Pago</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Completa el pago para continuar con tu inscripción</p>
    </div>

    @php $e = auth()->user()->estudiante; @endphp

    @if($config)
        {{-- Monto a pagar --}}
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="text-center mb-4">
                <p class="text-sm text-gray-500 mb-1">Monto a pagar</p>
                <p class="text-4xl font-bold text-green-700 dark:text-green-300">
                    Bs. {{ $e->es_extranjero ? number_format($config->precio_extranjero, 2) : number_format($config->precio_nacional, 2) }}
                </p>
                <x-badge :color="$e->es_extranjero ? 'yellow' : 'green'" class="mt-2">
                    {{ $e->es_extranjero ? 'Estudiante Extranjero' : 'Estudiante Nacional' }}
                </x-badge>
            </div>
        </div>

        {{-- Datos bancarios --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Datos Bancarios</h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                        <p class="text-[10px] text-gray-400 uppercase mb-1">Banco</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $config->banco }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                        <p class="text-[10px] text-gray-400 uppercase mb-1">N° de Cuenta</p>
                        <p class="text-lg font-mono font-bold text-gray-900 dark:text-white">{{ $config->cuenta }}</p>
                    </div>
                </div>

                @if($config->instrucciones)
                    <div class="p-4 bg-amber-50 dark:bg-amber-950/20 rounded-xl border border-amber-200 dark:border-amber-800">
                        <p class="text-xs font-medium text-amber-700 dark:text-amber-300 mb-1">Instrucciones:</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $config->instrucciones }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Código QR --}}
        @if($config->qr_path)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Código QR</h3>
                </div>
                <div class="p-5 text-center">
                    <p class="text-xs text-gray-500 mb-4">Escanea el código QR con tu aplicación bancaria</p>
                    <div class="inline-block p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <img src="{{ asset('storage/' . $config->qr_path) }}" alt="QR de Pago" class="w-48 h-48 object-contain">
                    </div>
                </div>
            </div>
        @endif

        {{-- Subir comprobante --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Subir Comprobante</h3>
                <p class="text-[10px] text-gray-400 mt-0.5">Después de realizar el pago, sube tu comprobante</p>
            </div>
            <div class="p-5">
                <form action="{{ route('estudiante.pago.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Comprobante de pago</label>
                        <input type="file" name="comprobante" accept=".pdf,.jpg,.jpeg,.png" required
                               class="w-full text-sm file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-950/30 dark:file:text-green-300 file:cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-4">
                        <p class="text-[10px] text-gray-400 mt-2">Formatos: PDF, JPG, PNG (máx. 2MB)</p>
                    </div>
                    <button type="submit" class="btn-primary text-sm px-6 py-3 w-full bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Subir comprobante de pago
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-slate-50 dark:bg-slate-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Configuración no disponible</h3>
            <p class="text-sm text-gray-500">La información de pago no ha sido configurada por el administrador.</p>
        </div>
    @endif
</div>
@endsection
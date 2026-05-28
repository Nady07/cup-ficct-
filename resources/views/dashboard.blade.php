<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <p class="text-lg mb-2">🎉 ¡Has iniciado sesión correctamente!</p>
                    <p class="text-sm text-gray-500">Redirigiendo a tu panel...</p>
                    <meta http-equiv="refresh" content="2;url={{ url('/dashboard') }}">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
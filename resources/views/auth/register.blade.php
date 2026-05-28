<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">🎓 Postulación CUP FICCT</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Formulario de Registro - Gestión I/2025</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        
        {{-- ═══════════ SECCIÓN: TIPO DE USUARIO ═══════════ --}}
        <div class="bg-blue-50 dark:bg-blue-950/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
            <label class="text-sm font-semibold text-gray-900 dark:text-white">Tipo de Postulación *</label>
            <p class="text-[10px] text-gray-500 mb-3">Selecciona si postulas como estudiante o docente</p>
            <div class="grid grid-cols-2 gap-3">
                <label class="relative flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl border-2 cursor-pointer transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-950/20">
                    <input type="radio" name="role" value="estudiante" class="sr-only" checked>
                    <span class="text-2xl">🧑‍🎓</span>
                    <div>
                        <p class="text-sm font-medium">Estudiante</p>
                        <p class="text-[10px] text-gray-400">Postulo al CUP</p>
                    </div>
                </label>
                <label class="relative flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl border-2 cursor-pointer transition-all has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 dark:has-[:checked]:bg-purple-950/20">
                    <input type="radio" name="role" value="docente" class="sr-only">
                    <span class="text-2xl">👨‍🏫</span>
                    <div>
                        <p class="text-sm font-medium">Docente</p>
                        <p class="text-[10px] text-gray-400">Postulo a dar clases</p>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- ═══════════ SECCIÓN: DATOS PERSONALES ═══════════ --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">👤 Datos Personales</h3>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-input-label for="ci" :value="__('Cédula de Identidad *')" />
                    <x-text-input id="ci" class="block mt-1 w-full text-sm" type="text" name="ci" :value="old('ci')" placeholder="12345678" required />
                    <x-input-error :messages="$errors->get('ci')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="name" :value="__('Nombre completo *')" />
                    <x-text-input id="name" class="block mt-1 w-full text-sm" type="text" name="name" :value="old('name')" placeholder="Juan Pérez Gómez" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento *')" />
                    <x-text-input id="fecha_nacimiento" class="block mt-1 w-full text-sm" type="date" name="fecha_nacimiento" :value="old('fecha_nacimiento')" required />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="sexo" :value="__('Sexo')" />
                    <select id="sexo" name="sexo" class="input-ficct mt-1 text-sm">
                        <option value="">Seleccionar...</option>
                        <option value="M" {{ old('sexo') === 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo') === 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="O" {{ old('sexo') === 'O' ? 'selected' : '' }}>Otro</option>
                    </select>
                    <x-input-error :messages="$errors->get('sexo')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico *')" />
                    <x-text-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')" placeholder="correo@ejemplo.com" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" class="block mt-1 w-full text-sm" type="text" name="telefono" :value="old('telefono')" placeholder="70000000" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-1" />
                </div>
                <div class="col-span-2">
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <x-text-input id="direccion" class="block mt-1 w-full text-sm" type="text" name="direccion" :value="old('direccion')" placeholder="Av. Principal #123" />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="ciudad" :value="__('Ciudad')" />
                    <x-text-input id="ciudad" class="block mt-1 w-full text-sm" type="text" name="ciudad" :value="old('ciudad')" placeholder="Santa Cruz" />
                    <x-input-error :messages="$errors->get('ciudad')" class="mt-1" />
                </div>
            </div>
        </div>

        {{-- ═══════════ SECCIÓN: DATOS ACADÉMICOS ═══════════ --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">📚 Datos Académicos</h3>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-input-label for="colegio_procedencia" :value="__('Colegio de Procedencia *')" />
                    <x-text-input id="colegio_procedencia" class="block mt-1 w-full text-sm" type="text" name="colegio_procedencia" :value="old('colegio_procedencia')" placeholder="Colegio Nacional..." required />
                    <x-input-error :messages="$errors->get('colegio_procedencia')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="anio_graduacion" :value="__('Año de Graduación *')" />
                    <x-text-input id="anio_graduacion" class="block mt-1 w-full text-sm" type="number" name="anio_graduacion" :value="old('anio_graduacion')" placeholder="2024" min="2000" max="2030" required />
                    <x-input-error :messages="$errors->get('anio_graduacion')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="carrera_interes_id" :value="__('Primera Opción de Carrera *')" />
                    <select id="carrera_interes_id" name="carrera_interes_id" class="input-ficct mt-1 text-sm" required>
                        <option value="">Seleccionar carrera...</option>
                        @foreach(\App\Models\Carrera::where('estado', true)->orderBy('nombre')->get() as $carrera)
                            <option value="{{ $carrera->id }}" {{ old('carrera_interes_id') == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->nombre }} ({{ $carrera->codigo }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('carrera_interes_id')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="carrera_opcion2_id" :value="__('Segunda Opción de Carrera')" />
                    <select id="carrera_opcion2_id" name="carrera_opcion2_id" class="input-ficct mt-1 text-sm">
                        <option value="">Seleccionar carrera...</option>
                        @foreach(\App\Models\Carrera::where('estado', true)->orderBy('nombre')->get() as $carrera)
                            <option value="{{ $carrera->id }}" {{ old('carrera_opcion2_id') == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->nombre }} ({{ $carrera->codigo }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('carrera_opcion2_id')" class="mt-1" />
                </div>
            </div>
        </div>

        {{-- ═══════════ SECCIÓN: SEGURIDAD ═══════════ --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">🔒 Seguridad</h3>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-input-label for="password" :value="__('Contraseña *')" />
                    <x-text-input id="password" class="block mt-1 w-full text-sm" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña *')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full text-sm" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a class="text-xs text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" href="{{ route('login') }}">
                ¿Ya tienes cuenta? Inicia sesión
            </a>
            <x-primary-button class="px-6 py-2.5">
                {{ __('Postularme al CUP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
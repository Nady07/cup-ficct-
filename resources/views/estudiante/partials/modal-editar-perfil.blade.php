@php $e = auth()->user()->estudiante; @endphp

<x-modal name="editar-perfil" maxWidth="2xl">
    <div class="p-6 max-h-[80vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Editar Perfil</h3>
        <form action="{{ route('estudiante.perfil.update') }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            
            <div>
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Datos Personales</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-input name="nombre" label="Nombres *" :value="old('nombre', $e->nombre)" required />
                    <x-input name="apellidos" label="Apellidos" :value="old('apellidos', $e->apellidos)" />
                    <x-input name="ci" label="CI *" :value="old('ci', $e->ci)" required />
                    <x-input name="fecha_nacimiento" label="Fecha Nacimiento *" type="date" :value="old('fecha_nacimiento', $e->fecha_nacimiento?->format('Y-m-d'))" required />
                    <div>
                        <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Sexo</label>
                        <select name="sexo" class="input-ficct text-xs">
                            <option value="">Seleccionar...</option>
                            <option value="M" {{ $e->sexo === 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $e->sexo === 'F' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                    <x-input name="email" label="Email *" type="email" :value="old('email', $e->email)" required />
                    <x-input name="telefono" label="Teléfono" :value="old('telefono', $e->telefono)" />
                    <x-input name="ciudad" label="Ciudad" :value="old('ciudad', $e->ciudad)" />
                    <div class="sm:col-span-2"><x-input name="direccion" label="Dirección" :value="old('direccion', $e->direccion)" /></div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Académico</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-input name="colegio_procedencia" label="Colegio *" :value="old('colegio_procedencia', $e->colegio_procedencia)" required />
                    <x-input name="anio_graduacion" label="Año Graduación *" type="number" :value="old('anio_graduacion', $e->anio_graduacion)" required />
                    <div>
                        <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">1ª Carrera *</label>
                        <select name="carrera_interes_id" class="input-ficct text-xs" required>
                            <option value="">Seleccionar...</option>
                            @foreach(\App\Models\Carrera::where('estado', true)->get() as $c)
                                <option value="{{ $c->id }}" {{ $e->carrera_interes_id == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">2ª Carrera</label>
                        <select name="carrera_opcion2_id" class="input-ficct text-xs">
                            <option value="">Ninguna</option>
                            @foreach(\App\Models\Carrera::where('estado', true)->get() as $c)
                                <option value="{{ $c->id }}" {{ $e->carrera_opcion2_id == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" @click="$dispatch('close-modal', 'editar-perfil')" class="btn-secondary text-xs px-4 py-2">Cancelar</button>
                <button type="submit" class="btn-primary text-xs px-4 py-2">Guardar</button>
            </div>
        </form>
    </div>
</x-modal>
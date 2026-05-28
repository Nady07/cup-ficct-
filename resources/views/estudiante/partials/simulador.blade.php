<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl" x-data="{ n1: 0, n2: 0, n3: 0, get p() { return ((+this.n1 + +this.n2 + +this.n3)/3).toFixed(1) || '0.0' }, get ok() { return +this.p >= 60 } }">
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Simulador de Promedio</h3>
    </div>
    <div class="p-5">
        <div class="flex flex-wrap items-center justify-center gap-3 mb-4">
            <input x-model="n1" type="number" min="0" max="100" placeholder="N1" class="w-20 h-12 text-center text-lg font-bold rounded-xl border-2 border-gray-200 dark:border-gray-700 focus:border-blue-500 transition-colors bg-gray-50 dark:bg-gray-800">
            <span class="text-gray-400 text-xl font-light">+</span>
            <input x-model="n2" type="number" min="0" max="100" placeholder="N2" class="w-20 h-12 text-center text-lg font-bold rounded-xl border-2 border-gray-200 dark:border-gray-700 focus:border-blue-500 transition-colors bg-gray-50 dark:bg-gray-800">
            <span class="text-gray-400 text-xl font-light">+</span>
            <input x-model="n3" type="number" min="0" max="100" placeholder="N3" class="w-20 h-12 text-center text-lg font-bold rounded-xl border-2 border-gray-200 dark:border-gray-700 focus:border-blue-500 transition-colors bg-gray-50 dark:bg-gray-800">
            <span class="text-gray-400 text-xl font-light">=</span>
            <div class="w-24 h-12 flex items-center justify-center rounded-xl text-xl font-bold"
                 :class="ok && p > 0 ? 'bg-green-50 dark:bg-green-950/20 text-green-600 border-2 border-green-300' : 'bg-gray-50 dark:bg-gray-800 text-gray-400 border-2 border-gray-200 dark:border-gray-700'">
                <span x-text="p"></span>
            </div>
        </div>
        <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mb-2">
            <div class="h-full rounded-full transition-all duration-700" :class="ok ? 'bg-gradient-to-r from-green-400 to-emerald-500' : 'bg-gradient-to-r from-red-400 to-rose-500'" :style="'width: ' + Math.min(p, 100) + '%'"></div>
        </div>
        <p class="text-center text-sm font-bold mt-2" :class="ok && p > 0 ? 'text-green-600' : 'text-red-600'">
            <span x-show="p >= 60">Aprobado</span>
            <span x-show="p < 60 && p > 0">Reprobado</span>
            <span x-show="p == 0" class="text-gray-400">Ingresa tus notas</span>
        </p>
    </div>
</div>
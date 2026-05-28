<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" class="bg-white dark:bg-dark-surface border-b border-gray-200 dark:border-dark-border transition-colors duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-ficct-blue dark:bg-ficct-light-blue rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">F</span>
                        </div>
                        <span class="hidden md:inline text-lg font-bold text-ficct-blue dark:text-ficct-gold">FICCT</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-nav-link>

                   {{-- MENÚ ESTUDIANTE --}}
                    @if(auth()->check() && auth()->user()->role === 'estudiante')
                        <x-nav-link :href="route('estudiante.dashboard')" :active="request()->routeIs('estudiante.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('estudiante.horario')" :active="request()->routeIs('estudiante.horario')">
                            {{ __('Horario') }}
                        </x-nav-link>
                        <x-nav-link :href="route('estudiante.calificaciones')" :active="request()->routeIs('estudiante.calificaciones')">
                            {{ __('Calificaciones') }}
                        </x-nav-link>
                        <x-nav-link :href="route('estudiante.docentes')" :active="request()->routeIs('estudiante.docentes')">
                            {{ __('Docentes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('estudiante.cup')" :active="request()->routeIs('estudiante.cup')">
                            {{ __('CUP') }}
                        </x-nav-link>
                    @endif

                    {{-- MENÚ ADMIN --}}
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Panel Admin') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown & Theme Toggle -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark')" 
                        class="inline-flex items-center p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-surface focus:outline-none transition">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.536l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.828-2.828a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm.707 5.657a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707zM9 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.536-2.464a1 1 0 01.707-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm0-2.828a1 1 0 001.414-1.414L4.464 9.17a1 1 0 10-1.414 1.414l.707.707zM4 11a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-dark-surface hover:text-gray-700 dark:hover:text-white focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden space-x-2">
                <!-- Theme Toggle Mobile -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark')" 
                        class="inline-flex items-center p-2 rounded-md text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-surface focus:outline-none transition">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.536l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.828-2.828a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm.707 5.657a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707zM9 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.536-2.464a1 1 0 01.707-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm0-2.828a1 1 0 001.414-1.414L4.464 9.17a1 1 0 10-1.414 1.414l.707.707zM4 11a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-surface focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white dark:bg-dark-surface border-t border-gray-200 dark:border-dark-border">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>

            {{-- MENÚ ADMIN RESPONSIVE --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Panel Admin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.materias.index')" :active="request()->routeIs('admin.materias.*')">
                    {{ __('Materias') }}
                </x-responsive-nav-link>
            @endif

            {{-- MENÚ ESTUDIANTE RESPONSIVE --}}
            @if(auth()->check() && auth()->user()->role === 'student')
                <x-responsive-nav-link :href="route('estudiante.horario')" :active="request()->routeIs('estudiante.horario')">
                    {{ __('Horario') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('estudiante.materias')" :active="request()->routeIs('estudiante.materias')">
                    {{ __('Materias') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('estudiante.docentes')" :active="request()->routeIs('estudiante.docentes')">
                    {{ __('Docentes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('estudiante.cup')" :active="request()->routeIs('estudiante.cup')">
                    {{ __('CUP') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-dark-border">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
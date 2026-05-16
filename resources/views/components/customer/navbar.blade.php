@php
    $user = Auth::user();
@endphp

<nav
    class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur dark:border-gray-800 dark:bg-gray-950/95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-6">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl bg-black text-white dark:bg-white dark:text-black">
                    <x-application-logo class="h-7 w-7" />
                </div>

                <span class="hidden text-lg font-bold text-gray-900 dark:text-white sm:block">
                    Car Rental Laravel
                </span>
            </a>

            {{-- Center public links --}}
            <div class="hidden items-center gap-8 lg:flex">
                <a href="{{ route('home') }}"
                    class="text-sm font-semibold transition {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-700 hover:text-blue-600 dark:text-gray-200 dark:hover:text-blue-400' }}">
                    Home
                </a>

                <a href="{{ route('cars.index') }}"
                    class="text-sm font-semibold transition {{ request()->routeIs('cars.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-700 hover:text-blue-600 dark:text-gray-200 dark:hover:text-blue-400' }}">
                    Cars
                </a>

                <a href="{{ route('home') }}#how-it-works"
                    class="text-sm font-semibold transition text-gray-700 hover:text-blue-600 dark:text-gray-200 dark:hover:text-blue-400">
                    How It Works
                </a>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                <button type="button" data-theme-toggle
                    class="flex h-11 w-11 items-center justify-center rounded-xl border border-gray-300 bg-white text-lg shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-800">
                    🌙
                </button>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <div class="flex items-center gap-3">

                        <button type="button" @click="open = !open"
                            class="inline-flex items-center gap-3 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <span>{{ auth()->user()->name }}</span>

                            <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 z-50 mt-3 w-72 overflow-hidden rounded-2xl border border-white/10 bg-slate-900 shadow-2xl"
                        style="display: none;">

                        <div class="border-b border-white/10 px-5 py-4">
                            <p class="font-bold text-white">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="mt-1 truncate text-sm text-gray-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('dashboard') }}"
                                class="block px-5 py-3 text-sm font-medium text-gray-200 transition hover:bg-white/5">
                                Dashboard
                            </a>

                            <a href="{{ route('cars.index') }}"
                                class="block px-5 py-3 text-sm font-medium text-gray-200 transition hover:bg-white/5">
                                Cars
                            </a>

                            <a href="{{ route('customer.favorites.index') }}"
                                class="block px-5 py-3 text-sm font-medium text-gray-200 transition hover:bg-white/5">
                                Favorites
                            </a>

                            <a href="{{ route('customer.document.create') }}"
                                class="block px-5 py-3 text-sm font-medium text-gray-200 transition hover:bg-white/5">
                                My Documents
                            </a>

                            <a href="{{ route('customer.rentals.index') }}"
                                class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                                My Rentals
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="block px-5 py-3 text-sm font-medium text-gray-200 transition hover:bg-white/5">
                                Profile
                            </a>
                        </div>

                        <div class="border-t border-white/10 py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                    class="block w-full px-5 py-3 text-left text-sm font-semibold text-red-400 transition hover:bg-red-500/10">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile links --}}
        <div class="flex gap-4 overflow-x-auto border-t border-gray-200 py-3 lg:hidden dark:border-gray-800">
            <a href="{{ route('home') }}"
                class="whitespace-nowrap text-sm font-semibold {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
                Home
            </a>

            <a href="{{ route('cars.index') }}"
                class="whitespace-nowrap text-sm font-semibold {{ request()->routeIs('cars.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
                Cars
            </a>

            <a href="{{ route('home') }}#how-it-works"
                class="whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300">
                How It Works
            </a>

            <a href="{{ route('dashboard') }}"
                class="whitespace-nowrap text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
                Dashboard
            </a>
        </div>
    </div>
</nav>

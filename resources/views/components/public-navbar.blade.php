@props([
    'variant' => 'solid',
])

@php
    $isTransparent = $variant === 'transparent';
@endphp

<nav x-data="{ scrolled: false, mobileOpen: false }" x-init="scrolled = window.scrollY > 40;
window.addEventListener('scroll', () => scrolled = window.scrollY > 40);" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="{
        'bg-white/95 text-gray-900 shadow-sm border-b border-gray-200 backdrop-blur dark:bg-gray-950/95 dark:text-gray-100 dark:border-gray-800': {{ $isTransparent ? 'true' : 'false' }} ?
            scrolled : true,
        'bg-transparent text-white': {{ $isTransparent ? 'true' : 'false' }} && !scrolled
    }">
    <div class="max-w-7xl mx-auto px-6">
        <div class="h-20 flex items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3 font-bold text-xl">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl overflow-hidden"
                    :class="{
                        'bg-black text-white dark:bg-white dark:text-gray-950': {{ $isTransparent ? 'true' : 'false' }} ?
                            scrolled : true,
                        'bg-white/15 text-white ring-1 ring-white/30': {{ $isTransparent ? 'true' : 'false' }} && !
                            scrolled
                    }">
                    <x-application-logo class="h-6 w-6 fill-current" />
                </span>

                <span class="hidden sm:inline">
                    Car Rental Laravel
                </span>
            </a>

            <div class="hidden lg:flex items-center gap-8 text-sm font-semibold">
                <a href="{{ route('home') }}"
                    class="hover:opacity-75 {{ request()->routeIs('home') ? 'opacity-100' : '' }}">
                    Home
                </a>

                <a href="{{ route('cars.index') }}"
                    class="hover:opacity-75 {{ request()->routeIs('cars.*') ? 'opacity-100' : '' }}">
                    Cars
                </a>

                <a href="{{ route('home') }}#how-it-works" class="hover:opacity-75">
                    How It Works
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-3">
                <form method="GET" action="{{ route('cars.index') }}" class="hidden xl:flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search cars..."
                        class="w-52 rounded-l-xl border-0 px-4 py-2.5 text-sm text-gray-900 dark:bg-gray-900 dark:text-gray-100 ring-1 ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-blue-600">

                    <button type="submit"
                        class="rounded-r-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Search
                    </button>
                </form>

                <button type="button" x-data="{
                    darkMode: document.documentElement.classList.contains('dark'),
                
                    toggleTheme() {
                        this.darkMode = !this.darkMode;
                
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    }
                }" @click="toggleTheme()"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl ring-1 ring-gray-300 dark:ring-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                    title="Toggle dark mode">
                    <span x-show="!darkMode" x-cloak>🌙</span>
                    <span x-show="darkMode" x-cloak>☀️</span>
                </button>

                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2.5 text-sm font-semibold hover:opacity-75">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Register
                    </a>
                @else
                    <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                        <button type="button" @click="userMenuOpen = !userMenuOpen"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                            <span>{{ Auth::user()->name }}</span>

                            <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': userMenuOpen }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="userMenuOpen" x-cloak x-transition
                            class="absolute right-0 mt-3 w-56 overflow-hidden rounded-2xl bg-white dark:bg-gray-900 shadow-xl ring-1 ring-gray-200 dark:ring-gray-800 z-50">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <div class="py-2">
                                @if (Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Admin Dashboard
                                    </a>

                                    <a href="{{ route('admin.cars.index') }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Manage Cars
                                    </a>

                                    <a href="{{ route('admin.customers.index') }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Customers
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Dashboard
                                    </a>

                                    <a href="{{ route('customer.favorites.index') }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        Favorites
                                    </a>

                                    <a href="{{ route('customer.document.create') }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        My Document
                                    </a>

                                    <a href="#"
                                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        My Rentals
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-800 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <button type="button"
                class="lg:hidden inline-flex items-center justify-center rounded-xl p-2 ring-1 ring-current/20"
                @click="mobileOpen = !mobileOpen">
                <span class="sr-only">Open menu</span>
                ☰
            </button>
        </div>

        <div x-show="mobileOpen" x-cloak class="lg:hidden pb-5">
            <div
                class="rounded-2xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 p-4 space-y-3">
                <a href="{{ route('home') }}" class="block font-semibold">Home</a>
                <a href="{{ route('cars.index') }}" class="block font-semibold">Cars</a>
                <a href="{{ route('home') }}#how-it-works" class="block font-semibold">How It Works</a>

                <button type="button" x-data="{
                    darkMode: document.documentElement.classList.contains('dark'),
                
                    toggleTheme() {
                        this.darkMode = !this.darkMode;
                
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    }
                }" @click="toggleTheme()"
                    class="w-full flex items-center justify-between rounded-xl px-4 py-2.5 font-semibold bg-gray-100 dark:bg-gray-800">
                    <span>Theme</span>
                    <span x-show="!darkMode" x-cloak>🌙 Dark</span>
                    <span x-show="darkMode" x-cloak>☀️ Light</span>
                </button>

                @auth
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block font-semibold">Admin Dashboard</a>
                    @else
                        <a href="{{ route('customer.favorites.index') }}" class="block font-semibold">Favorites</a>
                        <a href="{{ route('customer.document.create') }}" class="block font-semibold">My Document</a>
                        <a href="{{ route('dashboard') }}" class="block font-semibold">Dashboard</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-2.5 text-white font-semibold">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block font-semibold">Login</a>
                    <a href="{{ route('register') }}"
                        class="block rounded-xl bg-blue-600 px-4 py-2.5 text-white font-semibold text-center">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

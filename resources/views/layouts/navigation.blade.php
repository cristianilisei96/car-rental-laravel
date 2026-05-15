<nav x-data="{ open: false, openCars: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if (Auth::user()->is_admin === 1)
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                                {{ __('Customers') }}
                            </x-nav-link>

                            <!-- Cars Dropdown -->
                            <div x-data="{ openCars: false }" @mouseenter="openCars = true" @mouseleave="openCars = false"
                                class="relative hidden sm:flex sm:items-center">
                                <button type="button"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                                    {{ request()->routeIs('admin.cars.*') ||
                                    request()->routeIs('admin.brands.*') ||
                                    request()->routeIs('admin.models.*') ||
                                    request()->routeIs('admin.colors.*') ||
                                    request()->routeIs('admin.fuels.*') ||
                                    request()->routeIs('admin.seats.*') ||
                                    request()->routeIs('admin.statuses.*') ||
                                    request()->routeIs('admin.transmissions.*') ||
                                    request()->routeIs('admin.types.*')
                                        ? 'border-indigo-400 text-gray-900 dark:text-gray-100 focus:border-indigo-700'
                                        : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700' }}">
                                    Cars

                                    <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="openCars" x-transition
                                    class="absolute left-0 top-full z-50 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5"
                                    style="display: none;">
                                    <div class="py-1">
                                        <x-dropdown-link :href="route('admin.cars.index')">
                                            Cars
                                        </x-dropdown-link>

                                        <div class="border-t border-gray-100 dark:border-gray-600 my-1"></div>

                                        <x-dropdown-link :href="route('admin.brands.index')">
                                            Car Brands
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.models.index')">
                                            Car Models
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.colors.index')">
                                            Car Colors
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.fuels.index')">
                                            Car Fuels
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.seats.index')">
                                            Car Seats
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.statuses.index')">
                                            Car Statuses
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.transmissions.index')">
                                            Car Transmissions
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.types.index')">
                                            Car Types
                                        </x-dropdown-link>
                                    </div>
                                </div>
                            </div>

                            <x-nav-link href="#">
                                {{ __('Rentals') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user()->is_admin === 1)
                            @else
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('customer.document.create')">
                                    {{ __('My Document') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                @if (Auth::user()->is_admin === 1)
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                        {{ __('Customers') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.cars.index')" :active="request()->routeIs('admin.cars.*')">
                        {{ __('Cars') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.brands.index')" :active="request()->routeIs('admin.brands.*')">
                        {{ __('Car Brands') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.models.index')" :active="request()->routeIs('admin.models.*')">
                        {{ __('Car Models') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.colors.index')" :active="request()->routeIs('admin.colors.*')">
                        {{ __('Car Colors') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.fuels.index')" :active="request()->routeIs('admin.fuels.*')">
                        {{ __('Car Fuels') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.seats.index')" :active="request()->routeIs('admin.seats.*')">
                        {{ __('Car Seats') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.statuses.index')" :active="request()->routeIs('admin.statuses.*')">
                        {{ __('Car Statuses') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.transmissions.index')" :active="request()->routeIs('admin.transmissions.*')">
                        {{ __('Car Transmissions') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.types.index')" :active="request()->routeIs('admin.types.*')">
                        {{ __('Car Types') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="#">
                        {{ __('Rentals') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('customer.document.create')" :active="request()->routeIs('customer.document.*')">
                        {{ __('My Document') }}
                    </x-responsive-nav-link>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

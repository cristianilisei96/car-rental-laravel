<x-admin.layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Admin Dashboard
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Overview of customers, cars, rentals and car configuration data.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 space-y-10">

        {{-- MAIN STATS --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Main overview
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Quick access to the most important sections.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('admin.customers.index') }}"
                    class="group block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Customers
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $customersCount }}
                            </p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Registered customer accounts
                            </p>
                        </div>

                        <div class="text-3xl group-hover:scale-110 transition">
                            👤
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.cars.index') }}"
                    class="group block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Cars
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $carsCount }}
                            </p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Cars available in the fleet
                            </p>
                        </div>

                        <div class="text-3xl group-hover:scale-110 transition">
                            🚗
                        </div>
                    </div>
                </a>

                <a href="#"
                    class="group block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Rentals
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                0
                            </p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Reservations and rental requests
                            </p>
                        </div>

                        <div class="text-3xl group-hover:scale-110 transition">
                            📅
                        </div>
                    </div>
                </a>

            </div>
        </div>

        {{-- CAR MANAGEMENT --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Car management
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Manage the data used when creating or editing cars.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <a href="{{ route('admin.brands.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Brands</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $brandsCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">🏷️</span>
                    </div>
                </a>

                <a href="{{ route('admin.models.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Models</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $modelsCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">🚘</span>
                    </div>
                </a>

                <a href="{{ route('admin.colors.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Colors</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $colorsCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">🎨</span>
                    </div>
                </a>

                <a href="{{ route('admin.fuels.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Fuels</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $fuelsCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">⛽</span>
                    </div>
                </a>

                <a href="{{ route('admin.seats.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Seats</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $seatsCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">💺</span>
                    </div>
                </a>

                <a href="{{ route('admin.statuses.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Statuses</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $statusesCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">✅</span>
                    </div>
                </a>

                <a href="{{ route('admin.transmissions.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Transmissions</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $transmissionsCount }}
                            </p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">⚙️</span>
                    </div>
                </a>

                <a href="{{ route('admin.types.index') }}"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Types</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $typesCount }}</p>
                        </div>
                        <span class="text-2xl group-hover:scale-110 transition">🚙</span>
                    </div>
                </a>

            </div>
        </div>

    </div>
</x-admin.layout>

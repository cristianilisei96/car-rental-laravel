<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Customers Card -->
                <a href="{{ route('admin.customers.index') }}"
                    class="group block transform transition duration-200 hover:-translate-y-1">

                    <div
                        class="bg-white dark:bg-gray-800 shadow-md hover:shadow-xl
                rounded-2xl p-6 border border-gray-200 dark:border-gray-700">

                        <div class="flex items-center justify-between">

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Customers
                                </h3>

                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $customersCount }}
                                </p>
                            </div>

                            <div class="text-indigo-500 group-hover:scale-110 transition">
                                👤
                            </div>

                        </div>

                    </div>
                </a>

                <!-- Cars Card -->
                <a href="{{ route('admin.cars.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Cars</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $carsCount }}</p>
                    </div>
                </a>

                <!-- Rentals Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Rentals</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $brandsCount }}</p>
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="border-t border-gray-300 dark:border-gray-700 my-12"></div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Cars Brands Card -->
                <a href="{{ route('admin.brands.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Brand</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $brandsCount }}</p>
                    </div>
                </a>

                <!-- Car Color Card -->
                <a href="{{ route('admin.colors.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Color</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $colorsCount }}</p>
                    </div>
                </a>

                <!-- Car Fuel Card -->
                <a href="{{ route('admin.fuels.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Fuel</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $fuelsCount }}</p>
                    </div>
                </a>

                <!-- Car Model Card -->
                <a href="{{ route('admin.models.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Model</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $modelsCount }}</p>
                    </div>
                </a>

                <!-- Car Seat Card -->
                <a href="{{ route('admin.seats.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Seat</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $seatsCount }}</p>
                    </div>
                </a>

                <!-- Car Status Card -->
                <a href="{{ route('admin.statuses.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Status</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $statusesCount }}</p>
                    </div>
                </a>

                <!-- Car Transmission Card -->
                <a href="{{ route('admin.transmissions.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Transmission</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $transmissionsCount }}
                        </p>
                    </div>
                </a>

                <!-- Car Type Card -->
                <a href="{{ route('admin.types.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Type</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $typesCount }}</p>
                    </div>
                </a>

                <!-- Cars Card -->
                {{-- <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Cars</h3>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $carsCount }}</p>
            </div> --}}

                <!-- Poți adăuga alte card-uri aici -->
            </div>
        </div>
    </div>
</x-app-layout>

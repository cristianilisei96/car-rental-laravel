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
                <a href="{{ route('admin.customers.index') }}" class="hover:scale-105 transition">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Customers</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $customersCount }}</p>
                    </div>
                </a>

                <!-- Cars Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Cars</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $brandsCount }}</p>
                </div>

                <!-- Rentals Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Rentals</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $brandsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Cars Brands Card -->
            <a href="{{ route('brands.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Brand</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $brandsCount }}</p>
                </div>
            </a>

            <!-- Car Color Card -->
            <a href="{{ route('colors.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Color</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $colorsCount }}</p>
                </div>
            </a>

            <!-- Car Fuel Card -->
            <a href="{{ route('fuels.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Fuel</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $fuelsCount }}</p>
                </div>
            </a>

            <!-- Car Model Card -->
            <a href="{{ route('models.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Model</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $modelsCount }}</p>
                </div>
            </a>

            <!-- Car Seat Card -->
            <a href="{{ route('seats.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Seat</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $seatsCount }}</p>
                </div>
            </a>

            <!-- Car Status Card -->
            <a href="{{ route('statuses.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Status</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $statusesCount }}</p>
                </div>
            </a>

            <!-- Car Transmission Card -->
            <a href="{{ route('transmissions.index') }}" class="hover:scale-105 transition">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Car Transmission</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $transmissionsCount }}</p>
                </div>
            </a>

            <!-- Car Type Card -->
            <a href="{{ route('types.index') }}" class="hover:scale-105 transition">
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
<x-admin.layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Admin Dashboard
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Overview of customers, cars, rentals, payments and fleet configuration.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Hero / Admin overview --}}
        <div
            class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="relative p-8 sm:p-10">
                <div class="absolute right-8 top-8 hidden text-7xl opacity-10 sm:block">
                    🛠️
                </div>

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                            Admin control center
                        </p>

                        <h1 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Manage your rental business
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                            Track customer activity, rental requests, payments and fleet data from one place.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('admin.rentals.index') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            View rentals
                        </a>

                        <a href="{{ route('admin.cars.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                            Manage cars
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main stats --}}
        <div>
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Main overview
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Quick access to the most important business sections.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <a href="{{ route('admin.customers.index') }}"
                    class="group block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Customers
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $customersCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Registered customer accounts
                            </p>
                        </div>

                        <div class="text-3xl transition group-hover:scale-110">
                            👤
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.cars.index') }}"
                    class="group block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Cars
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $carsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Cars registered in the fleet
                            </p>
                        </div>

                        <div class="text-3xl transition group-hover:scale-110">
                            🚗
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                    class="group block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Rentals
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $rentalsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Total rental requests
                            </p>
                        </div>

                        <div class="text-3xl transition group-hover:scale-110">
                            📅
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                    class="group block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-green-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-green-500">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Paid revenue
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                €{{ number_format($paidRevenue ?? 0, 2) }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Rentals marked as paid
                            </p>
                        </div>

                        <div class="text-3xl transition group-hover:scale-110">
                            💶
                        </div>
                    </div>
                </a>

            </div>
        </div>

        {{-- Rental workflow --}}
        <div>
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Rental workflow
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Monitor rental requests, active rentals and payment status.
                    </p>
                </div>

                <a href="{{ route('admin.rentals.index') }}"
                    class="hidden rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 sm:inline-flex">
                    Manage rentals
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">

                <a href="{{ route('admin.rentals.index') }}"
                    class="group rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-yellow-900/60 dark:bg-yellow-950/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-yellow-800 dark:text-yellow-300">
                                Pending
                            </p>

                            <p class="mt-2 text-3xl font-bold text-yellow-900 dark:text-yellow-200">
                                {{ $pendingRentalsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-yellow-700/80 dark:text-yellow-300/80">
                                Waiting for approval
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">⏳</span>
                    </div>
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                    class="group rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-green-900/60 dark:bg-green-950/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-green-800 dark:text-green-300">
                                Approved
                            </p>

                            <p class="mt-2 text-3xl font-bold text-green-900 dark:text-green-200">
                                {{ $approvedRentalsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-green-700/80 dark:text-green-300/80">
                                Approved reservations
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">✅</span>
                    </div>
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                    class="group rounded-2xl border border-purple-200 bg-purple-50 p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-purple-900/60 dark:bg-purple-950/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-purple-800 dark:text-purple-300">
                                Active
                            </p>

                            <p class="mt-2 text-3xl font-bold text-purple-900 dark:text-purple-200">
                                {{ $activeRentalsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-purple-700/80 dark:text-purple-300/80">
                                Cars currently rented
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">🟣</span>
                    </div>
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                    class="group rounded-2xl border border-blue-200 bg-blue-50 p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-blue-900/60 dark:bg-blue-950/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">
                                Completed
                            </p>

                            <p class="mt-2 text-3xl font-bold text-blue-900 dark:text-blue-200">
                                {{ $completedRentalsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-blue-700/80 dark:text-blue-300/80">
                                Finished rentals
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">🏁</span>
                    </div>
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Unpaid / Pending
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $unpaidRentalsCount ?? 0 }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Payments not marked paid
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">💳</span>
                    </div>
                </a>

            </div>
        </div>

        {{-- Management shortcuts --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Quick actions --}}
            <div
                class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Quick actions
                </h3>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Jump directly into common admin tasks.
                </p>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('admin.rentals.index') }}"
                        class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-800 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-100 dark:hover:border-blue-500 dark:hover:text-blue-400">
                        <span>Review rental requests</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.cars.create') }}"
                        class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-800 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-100 dark:hover:border-blue-500 dark:hover:text-blue-400">
                        <span>Add new car</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.customers.index') }}"
                        class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-800 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-100 dark:hover:border-blue-500 dark:hover:text-blue-400">
                        <span>Manage customers</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.cars.index') }}"
                        class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-800 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-100 dark:hover:border-blue-500 dark:hover:text-blue-400">
                        <span>Manage fleet</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            {{-- Rental status explanation --}}
            <div
                class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Rental status flow
                </h3>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Current business flow implemented in the rental system.
                </p>

                <div class="mt-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <span
                            class="mt-0.5 rounded-full bg-yellow-100 px-2 py-1 text-xs font-bold text-yellow-700 dark:bg-yellow-950/40 dark:text-yellow-300">
                            1
                        </span>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Pending
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Customer submitted a request.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="mt-0.5 rounded-full bg-green-100 px-2 py-1 text-xs font-bold text-green-700 dark:bg-green-950/40 dark:text-green-300">
                            2
                        </span>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Approved
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Admin approved the reservation.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="mt-0.5 rounded-full bg-purple-100 px-2 py-1 text-xs font-bold text-purple-700 dark:bg-purple-950/40 dark:text-purple-300">
                            3
                        </span>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Active
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Customer picked up the car.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="mt-0.5 rounded-full bg-blue-100 px-2 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950/40 dark:text-blue-300">
                            4
                        </span>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Completed
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Customer returned the car.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment logic --}}
            <div
                class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Payment tracking
                </h3>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Cash and card payments are tracked separately from the rental status.
                </p>

                <div class="mt-6 space-y-4">
                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            Cash rentals
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Start as unpaid. Admin marks them as paid when the customer pays on pickup.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            Card rentals
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Currently simulated. Payment starts as pending and can be marked as paid by admin.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            Start rental rule
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            A rental can be started only after payment is marked as paid.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Car management --}}
        <div>
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Car management
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Manage the data used when creating or editing cars.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <a href="{{ route('admin.brands.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Brands
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $brandsCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">🏷️</span>
                    </div>
                </a>

                <a href="{{ route('admin.models.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Models
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $modelsCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">🚘</span>
                    </div>
                </a>

                <a href="{{ route('admin.colors.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Colors
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $colorsCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">🎨</span>
                    </div>
                </a>

                <a href="{{ route('admin.fuels.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Fuels
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $fuelsCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">⛽</span>
                    </div>
                </a>

                <a href="{{ route('admin.seats.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Seats
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $seatsCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">💺</span>
                    </div>
                </a>

                <a href="{{ route('admin.statuses.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Statuses
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $statusesCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">✅</span>
                    </div>
                </a>

                <a href="{{ route('admin.transmissions.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Transmissions
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $transmissionsCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">⚙️</span>
                    </div>
                </a>

                <a href="{{ route('admin.types.index') }}"
                    class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-500 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Types
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $typesCount ?? 0 }}
                            </p>
                        </div>

                        <span class="text-2xl transition group-hover:scale-110">🚙</span>
                    </div>
                </a>

            </div>
        </div>

    </div>
</x-admin.layout>

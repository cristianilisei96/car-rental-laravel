<x-customer.layout title="Available Cars | Car Rental Laravel">
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Available Cars
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Browse our available cars, compare details and choose the right car for your trip.
            </p>
        </div>
    </x-slot>
    <div class="py-10 bg-gray-100 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <form method="GET" action="{{ route('cars.index') }}"
                class="mb-10 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div class="md:col-span-2">
                        <label
                            class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Search
                        </label>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Volvo, Dacia, SUV, electric..."
                            class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500">
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Type
                        </label>

                        <select name="type_id"
                            class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                            <option value="">All types</option>

                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected(request('type_id') == $type->id)>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Fuel
                        </label>

                        <select name="fuel_id"
                            class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                            <option value="">All fuels</option>

                            @foreach ($fuels as $fuel)
                                <option value="{{ $fuel->id }}" @selected(request('fuel_id') == $fuel->id)>
                                    {{ $fuel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Transmission
                        </label>

                        <select name="transmission_id"
                            class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                            <option value="">All</option>

                            @foreach ($transmissions as $transmission)
                                <option value="{{ $transmission->id }}" @selected(request('transmission_id') == $transmission->id)>
                                    {{ $transmission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Showing only cars with status <span class="font-semibold">Available</span>.
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('cars.index') }}"
                            class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                            Reset
                        </a>

                        <button type="submit"
                            class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                            Apply filters
                        </button>
                    </div>
                </div>
            </form>

            @if ($carsByType->isEmpty())
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow p-10 text-center">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        No cars found
                    </h3>

                    <p class="text-gray-500 dark:text-gray-400 mt-2">
                        Try changing the search term or filters.
                    </p>
                </div>
            @else
                <div class="space-y-14">
                    @foreach ($carsByType as $typeName => $cars)
                        <section>
                            <div class="mb-6 flex items-center justify-between">
                                <div>
                                    <h2 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ $typeName }}
                                    </h2>
                                </div>

                                <span
                                    class="rounded-full bg-gray-200 dark:bg-gray-800 px-4 py-1.5 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $cars->count() }} {{ \Illuminate\Support\Str::plural('car', $cars->count()) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($cars as $car)
                                    @php
                                        $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();

                                        $maxDiscount = $car->discountRules
                                            ->where('is_active', true)
                                            ->max('discount_per_day');
                                    @endphp

                                    <div
                                        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-md dark:shadow-none overflow-hidden hover:shadow-xl dark:hover:border-gray-700 transition group">
                                        <div class="relative overflow-hidden bg-gray-200 dark:bg-gray-800">
                                            @if ($mainImage)
                                                <img src="{{ asset('storage/' . $mainImage->image_path) }}"
                                                    alt="{{ $car->name }}"
                                                    class="w-full h-60 object-cover group-hover:scale-105 transition duration-300">
                                            @else
                                                <div
                                                    class="w-full h-60 bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                                    No image
                                                </div>
                                            @endif

                                            <div class="absolute top-4 left-4">
                                                <span
                                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-black/80 text-white">
                                                    {{ $car->status->name ?? 'Available' }}
                                                </span>
                                            </div>

                                            @if ($maxDiscount)
                                                <div class="absolute bottom-4 left-4">
                                                    <span
                                                        class="rounded-full bg-blue-600 px-3 py-1 text-xs font-bold text-white shadow-lg">
                                                        Save up to €{{ number_format($maxDiscount, 2) }}/day
                                                    </span>
                                                </div>
                                            @endif

                                            @auth
                                                @if (!Auth::user()->is_admin)
                                                    @php
                                                        $isFavorite = Auth::user()->hasFavoriteCar($car->id);
                                                    @endphp

                                                    <form method="POST"
                                                        action="{{ route('customer.favorites.toggle', $car->id) }}"
                                                        class="absolute top-4 right-4">
                                                        @csrf

                                                        <button type="submit"
                                                            class="w-10 h-10 rounded-full bg-white/95 hover:bg-white shadow flex items-center justify-center text-xl transition
                                                {{ $isFavorite ? 'text-red-600 hover:text-red-700' : 'text-gray-900 hover:text-red-600' }}">
                                                            {{ $isFavorite ? '♥' : '♡' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth

                                            @guest
                                                <a href="{{ route('login') }}"
                                                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 hover:bg-white text-gray-900 hover:text-red-600 shadow flex items-center justify-center text-xl transition">
                                                    ♡
                                                </a>
                                            @endguest
                                        </div>

                                        <div class="p-6">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                                        {{ $car->name }}
                                                    </h3>

                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $car->brand->name ?? '-' }} {{ $car->model->name ?? '' }}
                                                    </p>
                                                </div>

                                                <div class="text-right shrink-0">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        From
                                                    </p>

                                                    <p class="text-xl font-bold text-gray-900 dark:text-white">
                                                        €{{ number_format($car->price_per_day, 2) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-3 gap-3 mt-6 text-center">
                                                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        Fuel
                                                    </p>

                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $car->fuel->name ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        Seats
                                                    </p>

                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $car->seat->seats ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        Gearbox
                                                    </p>

                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $car->transmission->name ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-6">
                                                <a href="{{ route('cars.show', $car->id) }}"
                                                    class="block w-full text-center bg-black hover:bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-semibold">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

</x-customer.layout>

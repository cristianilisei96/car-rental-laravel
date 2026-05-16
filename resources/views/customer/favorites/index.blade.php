<x-public-layout title="My Favorites | Car Rental Laravel">

    <main class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-screen pt-20">
        <section class="max-w-7xl mx-auto px-6 py-12">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-widest text-blue-600 dark:text-blue-400 font-bold">
                        Customer
                    </p>

                    <h1 class="mt-3 text-4xl font-bold text-gray-900 dark:text-white">
                        My Favorite Cars
                    </h1>

                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Cars saved to your favorites list.
                    </p>
                </div>

                <a href="{{ route('cars.index') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    Browse cars
                </a>
            </div>

            @if ($cars->isEmpty())
                <div
                    class="rounded-3xl border border-gray-200 bg-white p-10 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-3xl dark:bg-red-950/40">
                        ❤️
                    </div>

                    <h3 class="mt-5 text-2xl font-bold text-gray-900 dark:text-white">
                        No favorite cars yet
                    </h3>

                    <p class="mx-auto mt-3 max-w-xl text-gray-600 dark:text-gray-400">
                        Browse the available fleet and press the heart icon to save cars here.
                    </p>

                    <a href="{{ route('cars.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Browse available cars
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($cars as $car)
                        @php
                            $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();

                            $maxDiscount = $car->discountRules ?? collect();

                            $maxDiscountValue = $maxDiscount->where('is_active', true)->max('discount_per_day');
                        @endphp

                        <div
                            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">
                            <div class="relative">
                                @if ($mainImage)
                                    <img src="{{ asset('storage/' . $mainImage->image_path) }}"
                                        alt="{{ $car->name }}" class="h-56 w-full object-cover">
                                @else
                                    <div
                                        class="flex h-56 w-full items-center justify-center bg-gray-200 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        No image
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('customer.favorites.toggle', $car->id) }}"
                                    class="absolute right-4 top-4">
                                    @csrf

                                    <button type="submit"
                                        class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl text-red-500 shadow-md transition hover:scale-105 dark:bg-gray-950">
                                        ♥
                                    </button>
                                </form>

                                @if (!empty($maxDiscountValue))
                                    <div
                                        class="absolute bottom-4 left-4 rounded-full bg-blue-600 px-3 py-1 text-xs font-bold text-white shadow">
                                        Save up to €{{ number_format($maxDiscountValue, 2) }}/day
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                            {{ $car->name }}
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $car->brand->name ?? '-' }} {{ $car->model->name ?? '' }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            From
                                        </p>

                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            €{{ number_format($car->price_per_day, 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-3 gap-3">
                                    <div class="rounded-xl bg-gray-100 p-3 text-center dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Fuel
                                        </p>

                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $car->fuel->name ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-gray-100 p-3 text-center dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Seats
                                        </p>

                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $car->seat->name ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-gray-100 p-3 text-center dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Gearbox
                                        </p>

                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $car->transmission->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('cars.show', $car->id) }}"
                                        class="flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $cars->links() }}
                </div>
            @endif
        </section>
    </main>
</x-public-layout>

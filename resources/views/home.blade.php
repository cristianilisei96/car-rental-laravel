<x-public-layout :title="config('app.name', 'Car Rental Laravel')" navbarVariant="transparent">

    {{-- Hero Section --}}
    <section class="relative min-h-screen bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1511919884226-fd3cad34687c');">

        <div class="absolute inset-0 bg-black/55 dark:bg-black/75"></div>

        <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 text-center text-white">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.3em] text-blue-300">
                Premium Car Rental Platform
            </p>

            <h1 class="max-w-4xl text-5xl font-bold leading-tight md:text-7xl">
                Find Your Perfect Rental Car
            </h1>

            <p class="mt-6 max-w-2xl text-lg text-gray-200">
                Choose your dates, compare available cars and request your reservation after document approval.
            </p>

            <form action="{{ route('cars.index') }}" method="GET"
                class="mt-10 grid w-full max-w-4xl grid-cols-1 gap-4 rounded-3xl border border-white/20 bg-white/95 p-4 text-gray-900 shadow-2xl backdrop-blur md:grid-cols-4
    dark:border-gray-700 dark:bg-gray-900/95 dark:text-gray-100">

                <div class="text-left">
                    <label for="search"
                        class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        Search
                    </label>

                    <input id="search" name="search" type="text" placeholder="Volvo, SUV, electric..."
                        class="w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400
            focus:border-blue-500 focus:ring-blue-500
            dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500">
                </div>

                <div class="text-left">
                    <label for="pickup"
                        class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        Pick-up date
                    </label>

                    <input id="pickup" name="pickup_date" type="date"
                        class="w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900
            focus:border-blue-500 focus:ring-blue-500
            dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                </div>

                <div class="text-left">
                    <label for="return"
                        class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        Return date
                    </label>

                    <input id="return" name="return_date" type="date"
                        class="w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900
            focus:border-blue-500 focus:ring-blue-500
            dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full rounded-2xl bg-blue-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                        Search Cars
                    </button>
                </div>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const pickup = document.getElementById('pickup');
                    const returnDate = document.getElementById('return');

                    if (!pickup || !returnDate) {
                        return;
                    }

                    function formatDate(date) {
                        return date.toISOString().split('T')[0];
                    }

                    function addDays(date, days) {
                        const result = new Date(date);
                        result.setDate(result.getDate() + days);
                        return result;
                    }

                    const today = new Date();

                    const minPickupDate = addDays(today, 1);
                    const minReturnDate = addDays(today, 2);

                    pickup.min = formatDate(minPickupDate);
                    returnDate.min = formatDate(minReturnDate);

                    if (!pickup.value) {
                        pickup.value = formatDate(minPickupDate);
                    }

                    if (!returnDate.value) {
                        returnDate.value = formatDate(minReturnDate);
                    }

                    pickup.addEventListener('change', function() {
                        if (!pickup.value) {
                            returnDate.min = formatDate(minReturnDate);

                            if (!returnDate.value || returnDate.value < returnDate.min) {
                                returnDate.value = formatDate(minReturnDate);
                            }

                            return;
                        }

                        const selectedPickup = new Date(pickup.value);
                        const newMinReturn = addDays(selectedPickup, 1);
                        const newMinReturnString = formatDate(newMinReturn);

                        returnDate.min = newMinReturnString;

                        if (!returnDate.value || returnDate.value < newMinReturnString) {
                            returnDate.value = newMinReturnString;
                        }
                    });
                });
            </script>
        </div>
    </section>

    {{-- Trust / Benefits Section --}}
    <section class="bg-white py-16 dark:bg-gray-950">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 text-center md:grid-cols-4">

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-3 text-3xl">✅</div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Verified Customers
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Customers upload their documents before renting a car.
                </p>
            </div>

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-3 text-3xl">🚗</div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Available Cars
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Browse available cars and choose the best option for your trip.
                </p>
            </div>

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-3 text-3xl">💶</div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Transparent Prices
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Clear daily prices with duration-based rental discounts.
                </p>
            </div>

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-3 text-3xl">🔒</div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Secure Booking
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Rentals are allowed only after document approval.
                </p>
            </div>

        </div>
    </section>

    {{-- Featured Cars --}}
    <section id="featured-cars" class="bg-gray-100 py-20 scroll-mt-24 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-12 flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                        Featured Fleet
                    </p>

                    <h2 class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">
                        Featured Cars
                    </h2>

                    <p class="mt-3 max-w-2xl text-gray-600 dark:text-gray-400">
                        A quick look at some of the cars available in the rental fleet.
                    </p>
                </div>

                <a href="{{ route('cars.index') }}"
                    class="rounded-xl bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-950 dark:hover:bg-gray-200">
                    View all cars
                </a>
            </div>

            @if ($featuredCars->isEmpty())
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-10 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-gray-600 dark:text-gray-400">
                        No cars available yet.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    @foreach ($featuredCars as $car)
                        @php
                            $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();

                            $maxDiscount = $car->discountRules->where('is_active', true)->max('discount_per_day');
                        @endphp

                        <div
                            class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-md transition hover:shadow-xl dark:border-gray-800 dark:bg-gray-900 dark:shadow-none dark:hover:border-gray-700">
                            <div class="relative overflow-hidden">
                                @if ($mainImage)
                                    <img src="{{ asset('storage/' . $mainImage->image_path) }}"
                                        alt="{{ $car->name }}"
                                        class="h-56 w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div
                                        class="flex h-56 w-full items-center justify-center bg-gray-200 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        No image
                                    </div>
                                @endif

                                @if ($maxDiscount)
                                    <div class="absolute bottom-4 left-4">
                                        <span
                                            class="rounded-full bg-blue-600 px-3 py-1 text-xs font-bold text-white shadow-lg">
                                            Save up to €{{ number_format($maxDiscount, 2) }}/day
                                        </span>
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

                                <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                                    <div class="rounded-xl bg-gray-100 p-3 dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Fuel</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $car->fuel->name ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-gray-100 p-3 dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Seats</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $car->seat->seats ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-gray-100 p-3 dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Gearbox</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $car->transmission->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('cars.show', $car->id) }}"
                                    class="mt-6 block w-full rounded-xl bg-black px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="bg-white py-20 scroll-mt-24 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-6 text-center">

            <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                Simple process
            </p>

            <h2 class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">
                How It Works
            </h2>

            <p class="mx-auto mt-4 mb-12 max-w-2xl text-gray-600 dark:text-gray-400">
                Renting a car is simple, but every customer must have an approved document before making a reservation.
            </p>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="mb-4 text-5xl">📅</div>

                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Choose Dates
                    </h3>

                    <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                        Select your pickup and return dates to check available cars.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="mb-4 text-5xl">🚘</div>

                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Select Car
                    </h3>

                    <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                        Browse the fleet and open the details page for your preferred car.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="mb-4 text-5xl">🪪</div>

                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Upload Document
                    </h3>

                    <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                        Add your ID card, driver license or passport for verification.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="mb-4 text-5xl">🔑</div>

                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Book & Drive
                    </h3>

                    <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                        After approval, you can complete your reservation and enjoy the ride.
                    </p>
                </div>

            </div>
        </div>
    </section>

</x-public-layout>

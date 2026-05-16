<x-customer.layout title="Reserve {{ $car->name }} | Car Rental Laravel">
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Reserve car
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Choose your rental period and payment method.
            </p>
        </div>
    </x-slot>

    @php
        $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();

        $minPickupDate = now()->addDay()->toDateString();
        $minReturnDate = now()->addDays(2)->toDateString();
    @endphp

    <div class="bg-gray-100 dark:bg-gray-950 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div
                    class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('warning'))
                <div
                    class="mb-6 rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-yellow-800 dark:border-yellow-900/60 dark:bg-yellow-950/40 dark:text-yellow-300">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Reservation form --}}
                <div
                    class="lg:col-span-2 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex flex-col gap-6 md:flex-row">
                        <div class="md:w-72">
                            @if ($mainImage)
                                <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $car->name }}"
                                    class="h-48 w-full rounded-2xl object-cover">
                            @else
                                <div
                                    class="flex h-48 w-full items-center justify-center rounded-2xl bg-gray-200 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                    No image
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                                Selected car
                            </p>

                            <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $car->name }}
                            </h1>

                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ $car->brand->name ?? '-' }} {{ $car->model->name ?? '' }}
                                • {{ $car->fuel->name ?? '-' }}
                                • {{ $car->transmission->name ?? '-' }}
                            </p>

                            <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                                €{{ number_format($car->price_per_day, 2) }}
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">/ day</span>
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('customer.rentals.store', $car) }}" class="mt-8 space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="pickup_date"
                                    class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Pick-up date
                                </label>

                                <input id="pickup_date" name="pickup_date" type="date"
                                    value="{{ old('pickup_date', $priceDetails['pickup_date']) }}"
                                    min="{{ $minPickupDate }}"
                                    class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                                @error('pickup_date')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="return_date"
                                    class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Return date
                                </label>

                                <input id="return_date" name="return_date" type="date"
                                    value="{{ old('return_date', $priceDetails['return_date']) }}"
                                    min="{{ $minReturnDate }}"
                                    class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                                @error('return_date')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-3 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Payment method
                            </label>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <label
                                    class="cursor-pointer rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-950">
                                    <input type="radio" name="payment_method" value="cash"
                                        class="text-blue-600 focus:ring-blue-500" @checked(old('payment_method', 'cash') === 'cash')>

                                    <span class="ml-2 font-bold text-gray-900 dark:text-white">
                                        Cash on pickup
                                    </span>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Pay when you pick up the car. Payment status starts as unpaid.
                                    </p>
                                </label>

                                <label
                                    class="cursor-pointer rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-950">
                                    <input type="radio" name="payment_method" value="card"
                                        class="text-blue-600 focus:ring-blue-500" @checked(old('payment_method') === 'card')>

                                    <span class="ml-2 font-bold text-gray-900 dark:text-white">
                                        Card
                                    </span>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Card payments are simulated for now. Payment status starts as pending.
                                    </p>
                                </label>
                            </div>

                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('cars.show', $car) }}"
                                class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                                Back to car
                            </a>

                            <button type="submit"
                                class="inline-flex justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                                Submit rental request
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Price summary --}}
                <aside
                    class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 h-fit">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Price summary
                    </h2>

                    <div class="mt-6 space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Pick-up
                            </span>

                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($priceDetails['pickup_date'])->format('d.m.Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Return
                            </span>

                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($priceDetails['return_date'])->format('d.m.Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Rental days
                            </span>

                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $priceDetails['total_days'] }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Price per day
                            </span>

                            <span class="font-semibold text-gray-900 dark:text-white">
                                €{{ number_format($priceDetails['price_per_day'], 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Subtotal
                            </span>

                            <span class="font-semibold text-gray-900 dark:text-white">
                                €{{ number_format($priceDetails['subtotal_price'], 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Discount per day
                            </span>

                            <span class="font-semibold text-green-600 dark:text-green-400">
                                -€{{ number_format($priceDetails['discount_per_day'], 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Total discount
                            </span>

                            <span class="font-semibold text-green-600 dark:text-green-400">
                                -€{{ number_format($priceDetails['total_discount'], 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-bold text-gray-900 dark:text-white">
                                Total
                            </span>

                            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                €{{ number_format($priceDetails['total_price'], 2) }}
                            </span>
                        </div>

                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Discounts are applied automatically based on the selected rental period.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pickup = document.getElementById('pickup_date');
            const returnDate = document.getElementById('return_date');

            if (!pickup || !returnDate) {
                return;
            }

            const reservationUrl = @json(route('customer.rentals.create', $car));

            function addDays(dateString, days) {
                const date = new Date(dateString);
                date.setDate(date.getDate() + days);
                return date.toISOString().split('T')[0];
            }

            function reloadWithSelectedDates() {
                if (!pickup.value || !returnDate.value) {
                    return;
                }

                const url = new URL(reservationUrl, window.location.origin);
                url.searchParams.set('pickup_date', pickup.value);
                url.searchParams.set('return_date', returnDate.value);

                window.location.href = url.toString();
            }

            pickup.addEventListener('change', function() {
                if (!pickup.value) {
                    return;
                }

                const minReturn = addDays(pickup.value, 1);
                returnDate.min = minReturn;

                if (!returnDate.value || returnDate.value <= pickup.value) {
                    returnDate.value = minReturn;
                }

                reloadWithSelectedDates();
            });

            returnDate.addEventListener('change', function() {
                if (!pickup.value || !returnDate.value) {
                    return;
                }

                if (returnDate.value <= pickup.value) {
                    returnDate.value = addDays(pickup.value, 1);
                }

                reloadWithSelectedDates();
            });
        });
    </script>
</x-customer.layout>

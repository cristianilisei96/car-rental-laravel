<x-customer.layout title="My Rentals | Car Rental Laravel">
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                My Rentals
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View your rental requests, payment status and reservation history.
            </p>
        </div>
    </x-slot>

    <main class="min-h-screen bg-gray-100 py-10 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-900/60 dark:bg-green-950/40 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if ($rentals->isEmpty())
                <div
                    class="rounded-3xl border border-gray-200 bg-white p-10 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-3xl dark:bg-blue-950/40">
                        📅
                    </div>

                    <h3 class="mt-5 text-2xl font-bold text-gray-900 dark:text-white">
                        No rentals yet
                    </h3>

                    <p class="mx-auto mt-3 max-w-xl text-gray-600 dark:text-gray-400">
                        Your rental requests will appear here after you reserve a car.
                    </p>

                    <a href="{{ route('cars.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Browse cars
                    </a>
                </div>
            @else
                <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                            Rental history
                        </p>

                        <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            Your reservations
                        </h1>

                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Track your rental requests and payment information.
                        </p>
                    </div>

                    <a href="{{ route('cars.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Browse cars
                    </a>
                </div>

                <div class="space-y-5">
                    @foreach ($rentals as $rental)
                        @php
                            $mainImage =
                                $rental->car?->images?->firstWhere('is_main', true) ?? $rental->car?->images?->first();

                            $statusSlug = $rental->status?->slug;

                            $statusClasses = match ($statusSlug) {
                                'approved' => 'bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-300',
                                'active' => 'bg-purple-100 text-purple-700 dark:bg-purple-950/40 dark:text-purple-300',
                                'rejected' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300',
                                'cancelled' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300',
                                default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-950/40 dark:text-yellow-300',
                            };

                            $paymentStatusClasses = match ($rental->payment_status) {
                                'paid' => 'bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-300',
                                'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-950/40 dark:text-yellow-300',
                                'refunded' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300',
                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                            };
                        @endphp

                        <article
                            class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                            <div class="grid grid-cols-1 lg:grid-cols-12">
                                <div class="lg:col-span-3">
                                    @if ($mainImage)
                                        <img src="{{ asset('storage/' . $mainImage->image_path) }}"
                                            alt="{{ $rental->car?->name }}" class="h-64 w-full object-cover lg:h-full">
                                    @else
                                        <div
                                            class="flex h-64 w-full items-center justify-center bg-gray-200 text-gray-500 dark:bg-gray-800 dark:text-gray-400 lg:h-full">
                                            No image
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 lg:col-span-9">
                                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span
                                                    class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClasses }}">
                                                    {{ $rental->status?->name ?? 'Unknown' }}
                                                </span>

                                                <span
                                                    class="rounded-full px-3 py-1 text-xs font-bold {{ $paymentStatusClasses }}">
                                                    Payment: {{ ucfirst($rental->payment_status) }}
                                                </span>
                                            </div>

                                            <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $rental->car?->name ?? 'Deleted car' }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $rental->car?->brand?->name ?? '-' }}
                                                {{ $rental->car?->model?->name ?? '' }}
                                            </p>
                                        </div>

                                        <div class="text-left lg:text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Total
                                            </p>

                                            <p class="text-3xl font-bold text-gray-900 dark:text-white">
                                                €{{ number_format($rental->total_price, 2) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                                        <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                            <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                                Pick-up
                                            </p>

                                            <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                                {{ $rental->pickup_date->format('d.m.Y') }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                            <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                                Return
                                            </p>

                                            <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                                {{ $rental->return_date->format('d.m.Y') }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                            <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                                Days
                                            </p>

                                            <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                                {{ $rental->total_days }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                            <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                                Payment method
                                            </p>

                                            <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                                {{ ucfirst($rental->payment_method) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Price per day
                                            </p>

                                            <p class="font-bold text-gray-900 dark:text-white">
                                                €{{ number_format($rental->price_per_day, 2) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Discount
                                            </p>

                                            <p class="font-bold text-green-600 dark:text-green-400">
                                                -€{{ number_format($rental->total_discount, 2) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Created
                                            </p>

                                            <p class="font-bold text-gray-900 dark:text-white">
                                                {{ $rental->created_at->format('d.m.Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if (in_array($statusSlug, ['pending', 'approved']) && $rental->payment_status !== 'paid')
                                        <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                                            <form method="POST"
                                                action="{{ route('customer.rentals.cancel', $rental) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to cancel this rental request?')"
                                                    class="inline-flex rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                    Cancel rental
                                                </button>
                                            </form>
                                        </div>
                                    @elseif (in_array($statusSlug, ['pending', 'approved']) && $rental->payment_status === 'paid')
                                        <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                This rental is already paid. Please contact support to cancel it.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $rentals->links() }}
                </div>
            @endif
        </div>
    </main>
</x-customer.layout>

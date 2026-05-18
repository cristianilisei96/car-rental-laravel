<x-customer.layout title="Rental #{{ $rental->id }} | Car Rental Laravel">
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Rental Details
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View your reservation details, payment status and rental information.
            </p>
        </div>
    </x-slot>

    @php
        $mainImage = $rental->car?->images?->firstWhere('is_main', true) ?? $rental->car?->images?->first();

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

    <main class="min-h-screen bg-gray-100 py-10 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div
                    class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-900/60 dark:bg-green-950/40 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div
                    class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-yellow-800 dark:border-yellow-900/60 dark:bg-yellow-950/40 dark:text-yellow-300">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                        Rental history
                    </p>

                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        Rental #{{ $rental->id }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Created on {{ $rental->created_at->format('d.m.Y H:i') }}
                    </p>
                </div>

                <a href="{{ route('customer.rentals.index') }}"
                    class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                    Back to my rentals
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                <section
                    class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
                    @if ($mainImage)
                        <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $rental->car?->name }}"
                            class="h-72 w-full object-cover">
                    @else
                        <div
                            class="flex h-72 w-full items-center justify-center bg-gray-200 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            No image
                        </div>
                    @endif

                    <div class="p-6 sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClasses }}">
                                        {{ $rental->status?->name ?? 'Unknown' }}
                                    </span>

                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $paymentStatusClasses }}">
                                        Payment: {{ ucfirst($rental->payment_status) }}
                                    </span>

                                    <span
                                        class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ ucfirst($rental->payment_method) }}
                                    </span>
                                </div>

                                <h2 class="mt-4 text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $rental->car?->name ?? 'Deleted car' }}
                                </h2>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $rental->car?->brand?->name ?? '-' }}
                                    {{ $rental->car?->model?->name ?? '' }}
                                    • {{ $rental->car?->fuel?->name ?? '-' }}
                                    • {{ $rental->car?->transmission?->name ?? '-' }}
                                </p>
                            </div>

                            <div class="text-left sm:text-right">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Total
                                </p>

                                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                                    €{{ number_format($rental->total_price, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-2xl bg-gray-100 p-5 dark:bg-gray-950">
                                <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                    Pick-up
                                </p>

                                <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                    {{ $rental->pickup_date->format('d.m.Y') }}
                                    @if ($rental->pickup_time)
                                        <span class="ml-1 text-gray-500 dark:text-gray-400">
                                            {{ substr($rental->pickup_time, 0, 5) }}
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="rounded-2xl bg-gray-100 p-5 dark:bg-gray-950">
                                <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                    Return
                                </p>

                                <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                    {{ $rental->return_date->format('d.m.Y') }}
                                    @if ($rental->return_time)
                                        <span class="ml-1 text-gray-500 dark:text-gray-400">
                                            {{ substr($rental->return_time, 0, 5) }}
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="rounded-2xl bg-gray-100 p-5 dark:bg-gray-950">
                                <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                    Rental days
                                </p>

                                <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                    {{ $rental->total_days }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-gray-100 p-5 dark:bg-gray-950">
                                <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                    Payment method
                                </p>

                                <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                    {{ ucfirst($rental->payment_method) }}
                                </p>
                            </div>
                        </div>

                        @if (in_array($statusSlug, ['pending', 'approved']) && $rental->payment_status !== 'paid')
                            <div class="mt-8 border-t border-gray-200 pt-6 dark:border-gray-800">
                                <form method="POST" action="{{ route('customer.rentals.cancel', $rental) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to cancel this rental request?')"
                                        class="rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700">
                                        Cancel rental
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if (
                            $rental->actual_return_at ||
                                $rental->return_mileage ||
                                $rental->fuel_level ||
                                $rental->return_notes ||
                                $rental->damage_notes)
                            <div class="mt-8 border-t border-gray-200 pt-6 dark:border-gray-800">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    Return details
                                </h3>

                                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                            Actual return
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                            {{ $rental->actual_return_at ? $rental->actual_return_at->format('d.m.Y H:i') : '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                            Return mileage
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                            {{ $rental->return_mileage ? number_format($rental->return_mileage) . ' km' : '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                            Fuel / battery level
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                            {{ $rental->fuel_level ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                            Return notes
                                        </p>

                                        <p class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-300">
                                            {{ $rental->return_notes ?: 'No return notes added.' }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                                        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                            Damage notes
                                        </p>

                                        <p class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-300">
                                            {{ $rental->damage_notes ?: 'No damage notes added.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                <aside class="space-y-6">
                    <div
                        class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Price summary
                        </h3>

                        <div class="mt-6 space-y-4 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500 dark:text-gray-400">Price per day</span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    €{{ number_format($rental->price_per_day, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    €{{ number_format($rental->subtotal_price, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500 dark:text-gray-400">Discount</span>
                                <span class="font-semibold text-green-600 dark:text-green-400">
                                    -€{{ number_format($rental->total_discount, 2) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 dark:text-white">
                                    Total
                                </span>

                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    €{{ number_format($rental->total_price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Next steps
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            Your rental status and payment status will be updated by the admin. You can check this page
                            anytime for the latest information.
                        </p>
                    </div>
                </aside>
            </div>

            <div
                class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Rental timeline
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            View important updates about this rental.
                        </p>
                    </div>

                    <span
                        class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950/40 dark:text-blue-300">
                        {{ $rental->events->count() }} events
                    </span>
                </div>

                @if (!in_array($statusSlug, ['completed', 'cancelled', 'rejected']))
                    <form method="POST" action="{{ route('customer.rentals.messages.store', $rental) }}"
                        class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-950">
                        @csrf

                        <label for="message" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Send a message to admin
                        </label>

                        <textarea id="message" name="message" rows="3"
                            class="mt-2 w-full rounded-xl border-gray-300 bg-white text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            placeholder="Ask a question about this rental...">{{ old('message') }}</textarea>

                        @error('message')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <div class="mt-3 flex justify-end">
                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                Send message
                            </button>
                        </div>
                    </form>
                @endif

                <div class="mt-6 space-y-4">
                    @forelse ($rental->events as $event)
                        <div class="rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ str($event->type)->replace('_', ' ')->title() }}
                                    </p>

                                    @if ($event->message)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $event->message }}
                                        </p>
                                    @endif

                                    @if ($event->oldStatus || $event->newStatus)
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            Status:

                                            @if ($event->oldStatus && $event->newStatus)
                                                <span class="font-semibold">
                                                    {{ $event->oldStatus->name }}
                                                </span>
                                                →
                                                <span class="font-semibold">
                                                    {{ $event->newStatus->name }}
                                                </span>
                                            @elseif ($event->newStatus)
                                                <span class="font-semibold">
                                                    {{ $event->newStatus->name }}
                                                </span>
                                            @else
                                                <span class="font-semibold">
                                                    {{ $event->oldStatus->name }}
                                                </span>
                                            @endif
                                        </p>
                                    @endif
                                </div>

                                <div class="text-left sm:text-right">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        {{ $event->created_at->format('d.m.Y H:i') }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $event->user?->is_admin ? 'Admin' : 'Customer' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-300 p-4 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                No rental events yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</x-customer.layout>

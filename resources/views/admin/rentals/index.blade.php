<x-admin.layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Rentals
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage rental requests, payments and active rentals.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Flash messages --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-900/60 dark:bg-green-950/40 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div
                class="mb-6 rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-yellow-800 dark:border-yellow-900/60 dark:bg-yellow-950/40 dark:text-yellow-300">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('info'))
            <div
                class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-blue-800 dark:border-blue-900/60 dark:bg-blue-950/40 dark:text-blue-300">
                {{ session('info') }}
            </div>
        @endif

        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                    Admin
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    Rental Requests
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Approve requests, confirm payments and manage active rentals.
                </p>
            </div>
        </div>

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
                    Customer rental requests will appear here.
                </p>
            </div>
        @else
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
                                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClasses }}">
                                                {{ $rental->status?->name ?? 'Unknown' }}
                                            </span>

                                            <span
                                                class="rounded-full px-3 py-1 text-xs font-bold {{ $paymentStatusClasses }}">
                                                Payment: {{ ucfirst($rental->payment_status) }}
                                            </span>

                                            <span
                                                class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                                {{ ucfirst($rental->payment_method) }}
                                            </span>
                                        </div>

                                        <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                                            #{{ $rental->id }} - {{ $rental->car?->name ?? 'Deleted car' }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $rental->car?->brand?->name ?? '-' }}
                                            {{ $rental->car?->model?->name ?? '' }}
                                        </p>

                                        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                                            Customer:
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                {{ $rental->user?->name ?? 'Deleted user' }}
                                            </span>
                                            —
                                            {{ $rental->user?->email ?? '-' }}
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
                                            Created
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                            {{ $rental->created_at->format('d.m.Y H:i') }}
                                        </p>
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
                                            Subtotal
                                        </p>

                                        <p class="font-bold text-gray-900 dark:text-white">
                                            €{{ number_format($rental->subtotal_price, 2) }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div
                                    class="mt-6 flex flex-wrap gap-3 border-t border-gray-200 pt-6 dark:border-gray-800">
                                    @if ($statusSlug === 'pending')
                                        <form method="POST" action="{{ route('admin.rentals.approve', $rental) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.rentals.reject', $rental) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                onclick="return confirm('Reject this rental request?')"
                                                class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                Reject
                                            </button>
                                        </form>
                                    @endif

                                    @if (in_array($statusSlug, ['pending', 'approved']))
                                        <form method="POST" action="{{ route('admin.rentals.cancel', $rental) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" onclick="return confirm('Cancel this rental?')"
                                                class="rounded-xl bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif

                                    @if (in_array($statusSlug, ['approved', 'active']) && $rental->payment_status !== 'paid')
                                        <form method="POST"
                                            action="{{ route('admin.rentals.mark-as-paid', $rental) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                                Mark as paid
                                            </button>
                                        </form>
                                    @endif

                                    @if ($statusSlug === 'approved')
                                        <form method="POST" action="{{ route('admin.rentals.start', $rental) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-xl bg-purple-600 px-4 py-2 text-sm font-semibold text-white hover:bg-purple-700">
                                                Start rental
                                            </button>
                                        </form>
                                    @endif

                                    @if ($statusSlug === 'active')
                                        <form method="POST" action="{{ route('admin.rentals.complete', $rental) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" onclick="return confirm('Complete this rental?')"
                                                class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                                Complete rental
                                            </button>
                                        </form>
                                    @endif

                                    @if (in_array($statusSlug, ['completed', 'rejected', 'cancelled']))
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            No actions available for this rental.
                                        </span>
                                    @endif
                                </div>
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
</x-admin.layout>

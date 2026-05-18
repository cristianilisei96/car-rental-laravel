<x-admin.layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Complete Rental
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Add return details before closing this rental.
            </p>
        </div>
    </x-slot>

    @php
        $mainImage = $rental->car?->images?->firstWhere('is_main', true) ?? $rental->car?->images?->first();

        $scheduledReturn = $rental->return_date->format('Y-m-d') . 'T' . substr($rental->return_time ?? '17:00', 0, 5);
    @endphp

    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                    Return inspection
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    Complete rental #{{ $rental->id }}
                </h1>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ $rental->car?->name ?? 'Deleted car' }} —
                    {{ $rental->user?->name ?? 'Deleted user' }}
                </p>
            </div>

            <a href="{{ route('admin.rentals.show', $rental) }}"
                class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                Back to rental
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="lg:col-span-1">
                <div
                    class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    @if ($mainImage)
                        <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $rental->car?->name }}"
                            class="h-56 w-full object-cover">
                    @else
                        <div
                            class="flex h-56 w-full items-center justify-center bg-gray-200 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            No image
                        </div>
                    @endif

                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $rental->car?->name ?? 'Deleted car' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Scheduled return:
                        </p>

                        <p class="mt-1 font-bold text-gray-900 dark:text-white">
                            {{ $rental->return_date->format('d.m.Y') }}
                            {{ substr($rental->return_time ?? '17:00', 0, 5) }}
                        </p>

                        <div class="mt-5 rounded-2xl bg-gray-100 p-4 dark:bg-gray-950">
                            <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                Customer
                            </p>

                            <p class="mt-1 font-bold text-gray-900 dark:text-white">
                                {{ $rental->user?->name ?? '-' }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $rental->user?->email ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('admin.rentals.complete', $rental) }}"
                    class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="actual_return_at"
                                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Actual return date & time
                            </label>

                            <input id="actual_return_at" name="actual_return_at" type="datetime-local"
                                value="{{ old('actual_return_at', $scheduledReturn) }}"
                                class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                            @error('actual_return_at')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="return_mileage"
                                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Return mileage
                            </label>

                            <input id="return_mileage" name="return_mileage" type="number" min="0"
                                value="{{ old('return_mileage', $rental->return_mileage) }}" placeholder="e.g. 184250"
                                class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                            @error('return_mileage')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fuel_level"
                                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Fuel / battery level
                            </label>

                            <select id="fuel_level" name="fuel_level"
                                class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                                @foreach (['Full', '3/4', '1/2', '1/4', 'Empty', '100%', '75%', '50%', '25%'] as $level)
                                    <option value="{{ $level }}" @selected(old('fuel_level', $rental->fuel_level) === $level)>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>

                            @error('fuel_level')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="return_notes"
                            class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Return notes
                        </label>

                        <textarea id="return_notes" name="return_notes" rows="4" placeholder="General return notes..."
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">{{ old('return_notes', $rental->return_notes) }}</textarea>

                        @error('return_notes')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label for="damage_notes"
                            class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Damage notes
                        </label>

                        <textarea id="damage_notes" name="damage_notes" rows="4"
                            placeholder="Write visible damage notes, or leave empty if no damage..."
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">{{ old('damage_notes', $rental->damage_notes) }}</textarea>

                        @error('damage_notes')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.rentals.show', $rental) }}"
                            class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                            Cancel
                        </a>

                        <button type="submit"
                            onclick="return confirm('Complete this rental and make the car available again?')"
                            class="inline-flex justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                            Complete rental
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.layout>

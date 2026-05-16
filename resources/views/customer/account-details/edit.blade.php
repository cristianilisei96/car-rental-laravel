<x-customer.layout title="Account Details | Car Rental Laravel">
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Account Details
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Complete your rental profile before making reservations.
            </p>
        </div>
    </x-slot>

    <main class="min-h-screen bg-gray-100 py-10 dark:bg-gray-950">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

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

            @if ($errors->any())
                <div
                    class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            @php
                $isComplete = $profile->isComplete();
            @endphp

            <div
                class="mb-8 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                            Rental profile
                        </p>

                        <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $isComplete ? 'Your profile is complete' : 'Complete your account details' }}
                        </h1>

                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            These details help the rental company identify and contact you before approving a rental.
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-bold {{ $isComplete ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300' }}">
                        {{ $isComplete ? 'Complete' : 'Incomplete' }}
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.account-details.update') }}"
                class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Phone number
                        </label>

                        <input id="phone" name="phone" type="text" value="{{ old('phone', $profile->phone) }}"
                            placeholder="+40 700 000 000"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth"
                            class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Date of birth
                        </label>

                        <input id="date_of_birth" name="date_of_birth" type="date"
                            value="{{ old('date_of_birth', optional($profile->date_of_birth)->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('date_of_birth')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Address
                        </label>

                        <input id="address" name="address" type="text"
                            value="{{ old('address', $profile->address) }}" placeholder="Street, number, apartment"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('address')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            City
                        </label>

                        <input id="city" name="city" type="text" value="{{ old('city', $profile->city) }}"
                            placeholder="Piatra Neamț"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('city')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Country
                        </label>

                        <input id="country" name="country" type="text"
                            value="{{ old('country', $profile->country ?? 'Romania') }}"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('country')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code"
                            class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Postal code
                        </label>

                        <input id="postal_code" name="postal_code" type="text"
                            value="{{ old('postal_code', $profile->postal_code) }}" placeholder="Optional"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('postal_code')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="driver_license_number"
                            class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Driver license number
                        </label>

                        <input id="driver_license_number" name="driver_license_number" type="text"
                            value="{{ old('driver_license_number', $profile->driver_license_number) }}"
                            placeholder="License number"
                            class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        @error('driver_license_number')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                        Back to dashboard
                    </a>

                    <button type="submit"
                        class="inline-flex justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Save account details
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-customer.layout>

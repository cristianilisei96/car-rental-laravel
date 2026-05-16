<x-public-layout title="{{ $car->name }} | {{ config('app.name', 'Car Rental Laravel') }}">

    @php
        $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();
    @endphp

    <main class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-screen pt-20">
        <section class="max-w-7xl mx-auto px-6 py-12">

            <div class="mb-8 flex items-center justify-between gap-4">
                <a href="{{ route('cars.index') }}"
                    class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    ← Back to cars
                </a>

                @auth
                    @if (!Auth::user()->is_admin)
                        @php
                            $isFavorite = Auth::user()->hasFavoriteCar($car->id);
                        @endphp

                        <form method="POST" action="{{ route('customer.favorites.toggle', $car->id) }}">
                            @csrf

                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 px-4 py-2 text-sm font-semibold shadow-sm transition
                                {{ $isFavorite ? 'text-red-600 hover:text-red-700' : 'text-gray-700 dark:text-gray-200 hover:text-red-600' }}">
                                <span class="text-lg leading-none">
                                    {{ $isFavorite ? '♥' : '♡' }}
                                </span>

                                <span>
                                    {{ $isFavorite ? 'Remove from favorites' : 'Add to favorites' }}
                                </span>
                            </button>
                        </form>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-red-600 shadow-sm transition">
                        <span class="text-lg leading-none">♡</span>
                        <span>Add to favorites</span>
                    </a>
                @endguest
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

                {{-- Images --}}
                <div x-data="{
                    activeImage: '{{ $mainImage ? asset('storage/' . $mainImage->image_path) : '' }}'
                }">
                    @if ($mainImage)
                        <div
                            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-md dark:shadow-none overflow-hidden">
                            <img :src="activeImage" alt="{{ $car->name }}"
                                class="w-full aspect-video object-cover">
                        </div>
                    @else
                        <div
                            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-md dark:shadow-none aspect-video flex items-center justify-center text-gray-500 dark:text-gray-400">
                            No image available
                        </div>
                    @endif

                    @if ($car->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3 mt-4">
                            @foreach ($car->images->take(8) as $image)
                                @php
                                    $imageUrl = asset('storage/' . $image->image_path);
                                @endphp

                                <button type="button" @click="activeImage = '{{ $imageUrl }}'"
                                    class="rounded-xl overflow-hidden border-2 transition hover:scale-[1.02] focus:outline-none bg-white dark:bg-gray-900"
                                    :class="activeImage === '{{ $imageUrl }}'
                                        ?
                                        'border-green-500' :
                                        'border-gray-200 dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600'">
                                    <img src="{{ $imageUrl }}" alt="{{ $car->name }}"
                                        class="w-full h-24 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-md dark:shadow-none p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wide">
                                {{ $car->type->name ?? 'Rental car' }}
                            </p>

                            <h1 class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">
                                {{ $car->name }}
                            </h1>

                            <p class="text-gray-500 dark:text-gray-400 mt-2">
                                {{ $car->brand->name ?? '-' }} {{ $car->model->name ?? '' }}
                            </p>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Price per day
                            </p>

                            <p class="text-3xl font-bold text-gray-900 dark:text-white">
                                €{{ number_format($car->price_per_day, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Year</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $car->year }}</p>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Fuel</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $car->fuel->name ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Transmission</p>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $car->transmission->name ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Seats</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $car->seat->seats ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $car->type->name ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Color</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $car->color->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Description
                        </h2>

                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ $car->description ?: 'No description available for this car yet.' }}
                        </p>
                    </div>

                    @if ($car->discountRules->where('is_active', true)->isNotEmpty())
                        <div class="mt-8">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                Available discounts
                            </h2>

                            <div class="space-y-3">
                                @foreach ($car->discountRules->where('is_active', true)->sortBy('min_days') as $rule)
                                    <div
                                        class="flex items-center justify-between rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900 px-4 py-3">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $rule->min_days }}+ rental days
                                        </span>

                                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">
                                            -€{{ number_format($rule->discount_per_day, 2) }}/day
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 border-t border-gray-200 dark:border-gray-800 pt-6">
                        @auth
                            @if (!Auth::user()->is_admin)
                                <a href="#"
                                    class="block w-full text-center bg-black hover:bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                                    Continue to reservation
                                </a>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 text-center">
                                    You need an approved document before completing a reservation.
                                </p>
                            @else
                                <a href="{{ route('admin.cars.show', $car->id) }}"
                                    class="block w-full text-center bg-black hover:bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                                    Open in admin
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full text-center bg-black hover:bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                                Login to reserve
                            </a>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 text-center">
                                Create an account and upload your document before renting.
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-public-layout>

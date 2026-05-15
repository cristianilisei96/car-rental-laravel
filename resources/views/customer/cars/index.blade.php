<x-public-layout title="Available Cars | Car Rental Laravel">

    <main class="bg-gray-100 min-h-screen">
        <section class="max-w-7xl mx-auto px-6 py-12">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
                        Rental Fleet
                    </p>

                    <h1 class="mt-2 text-4xl font-bold text-gray-900">
                        Available Cars
                    </h1>

                    <p class="text-gray-600 mt-3 max-w-2xl">
                        Browse our available cars, compare details and choose the right car for your trip.
                    </p>
                </div>

                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-black hover:bg-gray-800 text-white text-sm font-semibold rounded-xl">
                    ← Back home
                </a>
            </div>

            @if ($cars->isEmpty())
                <div class="bg-white rounded-2xl shadow p-10 text-center">
                    <h3 class="text-xl font-semibold text-gray-900">
                        No cars available yet
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Cars added by the admin will appear here.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($cars as $car)
                        @php
                            $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();
                        @endphp

                        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition group">
                            <div class="relative overflow-hidden">
                                @if ($mainImage)
                                    <img src="{{ asset('storage/' . $mainImage->image_path) }}"
                                        alt="{{ $car->name }}"
                                        class="w-full h-60 object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-60 bg-gray-200 flex items-center justify-center text-gray-500">
                                        No image
                                    </div>
                                @endif

                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-black/80 text-white">
                                        {{ $car->status->name ?? 'Available' }}
                                    </span>
                                </div>

                                @auth
                                    @if (!Auth::user()->is_admin)
                                        @php
                                            $isFavorite = Auth::user()->hasFavoriteCar($car->id);
                                        @endphp

                                        <form method="POST" action="{{ route('customer.favorites.toggle', $car->id) }}"
                                            class="absolute top-4 right-4">
                                            @csrf

                                            <button type="submit"
                                                class="w-10 h-10 rounded-full bg-white/90 hover:bg-white text-gray-900 shadow flex items-center justify-center text-lg">
                                                {{ $isFavorite ? '♥' : '♡' }}
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}"
                                        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-gray-900 shadow flex items-center justify-center text-lg">
                                        ♡
                                    </a>
                                @endguest
                            </div>

                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">
                                            {{ $car->name }}
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $car->brand->name ?? '-' }} {{ $car->model->name ?? '' }}
                                        </p>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <p class="text-xs text-gray-500">
                                            From
                                        </p>

                                        <p class="text-xl font-bold text-gray-900">
                                            €{{ number_format($car->price_per_day, 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 mt-6 text-center">
                                    <div class="bg-gray-100 rounded-xl p-3">
                                        <p class="text-xs text-gray-500">Fuel</p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $car->fuel->name ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="bg-gray-100 rounded-xl p-3">
                                        <p class="text-xs text-gray-500">Seats</p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $car->seat->seats ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="bg-gray-100 rounded-xl p-3">
                                        <p class="text-xs text-gray-500">Gearbox</p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $car->transmission->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('cars.show', $car->id) }}"
                                        class="block w-full text-center bg-black hover:bg-gray-800 text-white px-4 py-3 rounded-xl text-sm font-semibold">
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

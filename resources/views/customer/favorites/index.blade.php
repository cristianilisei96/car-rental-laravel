<x-public-layout title="My Favorites | Car Rental Laravel">
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-sm uppercase tracking-widest text-gray-500 font-semibold">
                    Customer
                </p>

                <h1 class="text-3xl font-bold text-gray-900">
                    My Favorite Cars
                </h1>

                <p class="text-gray-600 mt-2">
                    Cars saved to your favorites list.
                </p>
            </div>

            <a href="{{ route('cars.index') }}"
                class="px-4 py-2 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-lg">
                Browse cars
            </a>
        </div>

        @if ($cars->isEmpty())
            <div class="bg-white rounded-2xl shadow p-10 text-center">
                <h3 class="text-xl font-semibold text-gray-900">
                    No favorite cars yet
                </h3>

                <p class="text-gray-500 mt-2">
                    Go to the cars page and press the heart icon to save cars here.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($cars as $car)
                    @php
                        $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();
                    @endphp

                    <div class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-xl transition">
                        @if ($mainImage)
                            <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $car->name }}"
                                class="w-full h-56 object-cover">
                        @else
                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-500">
                                No image
                            </div>
                        @endif

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

                                <p class="text-lg font-bold">
                                    €{{ number_format($car->price_per_day, 2) }}
                                </p>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <a href="{{ route('cars.show', $car->id) }}"
                                    class="flex-1 text-center bg-black hover:bg-gray-800 text-white px-4 py-3 rounded-xl text-sm font-semibold">
                                    View Details
                                </a>

                                <form method="POST" action="{{ route('customer.favorites.toggle', $car->id) }}">
                                    @csrf

                                    <button type="submit"
                                        class="px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 text-sm font-semibold">
                                        ♥
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $cars->links() }}
            </div>
        @endif
    </main>

</x-public-layout>

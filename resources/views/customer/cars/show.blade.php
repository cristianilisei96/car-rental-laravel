<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $car->name }} | {{ config('app.name', 'Car Rental Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 text-gray-900">

    @php
        $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();
    @endphp

    {{-- Public Navbar --}}
    <nav class="bg-black text-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold">
                Car Rental Laravel
            </a>

            <div class="space-x-4 text-sm flex items-center">
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <a href="{{ route('home') }}#featured-cars" class="hover:underline">Featured Cars</a>
                <a href="{{ route('home') }}#how-it-works" class="hover:underline">How It Works</a>

                @auth
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="hover:underline">Admin Dashboard</a>
                    @else
                        <a href="{{ route('customer.document.create') }}" class="hover:underline">My Document</a>
                        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white text-black px-4 py-2 rounded-md hover:bg-gray-200">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-black px-4 py-2 rounded-md hover:bg-gray-200">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="mb-6">
            <a href="{{ route('cars.index') }}#featured-cars" class="text-sm text-gray-600 hover:text-black">
                ← Back to cars
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

            {{-- Images --}}
            <div x-data="{
                activeImage: '{{ $mainImage ? asset('storage/' . $mainImage->image_path) : '' }}'
            }">
                @if ($mainImage)
                    <div class="bg-white rounded-2xl shadow overflow-hidden">
                        <img :src="activeImage" alt="{{ $car->name }}" class="w-full aspect-video object-cover">
                    </div>
                @else
                    <div
                        class="bg-white rounded-2xl shadow aspect-video flex items-center justify-center text-gray-500">
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
                                class="rounded-lg overflow-hidden shadow border-2 transition hover:scale-[1.02] focus:outline-none"
                                :class="activeImage === '{{ $imageUrl }}'
                                    ?
                                    'border-green-500' :
                                    'border-transparent hover:border-gray-300'">
                                <img src="{{ $imageUrl }}" alt="{{ $car->name }}"
                                    class="w-full h-24 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="bg-white rounded-2xl shadow p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold">
                            {{ $car->name }}
                        </h1>

                        <p class="text-gray-500 mt-2">
                            {{ $car->brand->name ?? '-' }} {{ $car->model->name ?? '' }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-500">Price per day</p>
                        <p class="text-3xl font-bold">
                            €{{ number_format($car->price_per_day, 2) }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="p-4 bg-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500">Year</p>
                        <p class="font-semibold">{{ $car->year }}</p>
                    </div>

                    <div class="p-4 bg-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500">Fuel</p>
                        <p class="font-semibold">{{ $car->fuel->name ?? '-' }}</p>
                    </div>

                    <div class="p-4 bg-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500">Transmission</p>
                        <p class="font-semibold">{{ $car->transmission->name ?? '-' }}</p>
                    </div>

                    <div class="p-4 bg-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500">Seats</p>
                        <p class="font-semibold">{{ $car->seat->seats ?? '-' }}</p>
                    </div>

                    <div class="p-4 bg-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500">Type</p>
                        <p class="font-semibold">{{ $car->type->name ?? '-' }}</p>
                    </div>

                    <div class="p-4 bg-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500">Color</p>
                        <p class="font-semibold">{{ $car->color->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-2">Description</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $car->description ?: 'No description available for this car yet.' }}
                    </p>
                </div>

                <div class="mt-8 border-t pt-6">
                    @auth
                        @if (!Auth::user()->is_admin)
                            <a href="#"
                                class="block w-full text-center bg-black text-white px-6 py-3 rounded-xl hover:bg-gray-800 font-semibold">
                                Continue to reservation
                            </a>

                            <p class="text-sm text-gray-500 mt-3 text-center">
                                You need an approved document before completing a reservation.
                            </p>
                        @else
                            <a href="{{ route('admin.cars.show', $car->id) }}"
                                class="block w-full text-center bg-gray-800 text-white px-6 py-3 rounded-xl hover:bg-gray-700 font-semibold">
                                Open in admin
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-black text-white px-6 py-3 rounded-xl hover:bg-gray-800 font-semibold">
                            Login to reserve
                        </a>

                        <p class="text-sm text-gray-500 mt-3 text-center">
                            Create an account and upload your document before renting.
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <x-public-footer />

</body>

</html>

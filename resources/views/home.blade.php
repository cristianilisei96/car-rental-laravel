<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Car Rental Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased bg-gray-100">

    <!-- Navbar -->
    <nav class="absolute w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center text-white">
            <h1 class="text-2xl font-bold">Car Rental Laravel</h1>

            <div class="space-x-4">
                <a href="#featured-cars" class="hover:underline">Featured Cars</a>
                <a href="#how-it-works" class="hover:underline">How It Works</a>
                @guest
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-black px-4 py-2 rounded-md hover:bg-gray-200">
                        Register
                    </a>
                @else
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="hover:underline">Admin Dashboard</a>
                    @else
                        <a href="#" class="hover:underline">My Reservations</a>
                        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="hover:underline">Profile</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-white text-black px-4 py-2 rounded-md hover:bg-gray-200">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="relative h-screen bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1511919884226-fd3cad34687c');">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center items-center h-full text-center text-white px-6">

            <h1 class="text-5xl font-bold mb-4">
                Find Your Perfect Rental Car
            </h1>

            <p class="mb-8 text-lg">
                Choose your dates and discover available cars instantly
            </p>


            <!-- Search form -->
            <form action="#" method="GET"
                class="bg-white text-black rounded-xl shadow-lg p-6 grid md:grid-cols-3 gap-4">
                <input id="pickup" name="pickup_date" type="date" class="border rounded-md px-4 py-2" required>

                <input id="return" name="return_date" type="date" class="border rounded-md px-4 py-2" required>

                <button type="submit" class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800">
                    Search Cars
                </button>
            </form>

            <script>
                const pickup = document.getElementById('pickup');
                const ret = document.getElementById('return');

                // Setează data minimă pentru pickup la mâine
                window.addEventListener('DOMContentLoaded', function() {
                    const today = new Date();
                    today.setDate(today.getDate() + 1);
                    const minPickup = today.toISOString().split('T')[0];
                    pickup.min = minPickup;
                });

                pickup.addEventListener('change', function() {
                    if (pickup.value) {
                        // Set return min la pickup + 1 zi
                        const minDate = new Date(pickup.value);
                        minDate.setDate(minDate.getDate() + 1);
                        const minStr = minDate.toISOString().split('T')[0];
                        ret.min = minStr;

                        if (ret.value < minStr) {
                            ret.value = minStr;
                        }
                    } else {
                        ret.min = '';
                    }
                });
            </script>

        </div>
    </section>


    <!-- Trust / Benefits Section -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-6 text-center">

            <div class="p-6 rounded-xl border border-gray-200 shadow-sm bg-white">
                <div class="text-3xl mb-3">✅</div>
                <h3 class="font-semibold text-lg">Verified Customers</h3>
                <p class="text-gray-600 text-sm mt-2">
                    Customers upload their documents before renting a car.
                </p>
            </div>

            <div class="p-6 rounded-xl border border-gray-200 shadow-sm bg-white">
                <div class="text-3xl mb-3">🚗</div>
                <h3 class="font-semibold text-lg">Available Cars</h3>
                <p class="text-gray-600 text-sm mt-2">
                    Browse available cars and choose the best option for your trip.
                </p>
            </div>

            <div class="p-6 rounded-xl border border-gray-200 shadow-sm bg-white">
                <div class="text-3xl mb-3">💶</div>
                <h3 class="font-semibold text-lg">Transparent Prices</h3>
                <p class="text-gray-600 text-sm mt-2">
                    Clear daily prices with no hidden rental fees.
                </p>
            </div>

            <div class="p-6 rounded-xl border border-gray-200 shadow-sm bg-white">
                <div class="text-3xl mb-3">🔒</div>
                <h3 class="font-semibold text-lg">Secure Booking</h3>
                <p class="text-gray-600 text-sm mt-2">
                    Rentals are allowed only after document approval.
                </p>
            </div>

        </div>
    </section>

    <!-- Featured Cars -->
    <section id="featured-cars" class="bg-gray-100 py-20 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">
                Featured Cars
            </h2>

            @if ($featuredCars->isEmpty())
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <p class="text-gray-600">
                        No cars available yet.
                    </p>
                </div>
            @else
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($featuredCars as $car)
                        @php
                            $mainImage = $car->images->firstWhere('is_main', true) ?? $car->images->first();
                        @endphp

                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                            @if ($mainImage)
                                <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $car->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    No image
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2">
                                    {{ $car->name }}
                                </h3>

                                <p class="text-gray-600 mb-4">
                                    {{ $car->transmission->name ?? '-' }}
                                    •
                                    {{ $car->fuel->name ?? '-' }}
                                    •
                                    {{ $car->seat->seats ?? '-' }} Seats
                                </p>

                                <div class="flex justify-between items-center gap-4">
                                    <span class="text-lg font-bold">
                                        €{{ number_format($car->price_per_day, 2) }}/day
                                    </span>

                                    <a href="#"
                                        class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="bg-white py-20 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">

            <h2 class="text-3xl font-bold mb-4">
                How It Works
            </h2>

            <p class="text-gray-600 mb-12 max-w-2xl mx-auto">
                Renting a car is simple, but every customer must have an approved document before making a reservation.
            </p>

            <div class="grid md:grid-cols-4 gap-8">

                <div class="p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-5xl mb-4">📅</div>
                    <h3 class="text-xl font-semibold mb-2">Choose Dates</h3>
                    <p class="text-gray-600 text-sm">
                        Select your pickup and return dates to check available cars.
                    </p>
                </div>

                <div class="p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-5xl mb-4">🚘</div>
                    <h3 class="text-xl font-semibold mb-2">Select Car</h3>
                    <p class="text-gray-600 text-sm">
                        Browse the fleet and open the details page for your preferred car.
                    </p>
                </div>

                <div class="p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-5xl mb-4">🪪</div>
                    <h3 class="text-xl font-semibold mb-2">Upload Document</h3>
                    <p class="text-gray-600 text-sm">
                        Add your ID card, driver license or passport for verification.
                    </p>
                </div>

                <div class="p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-5xl mb-4">🔑</div>
                    <h3 class="text-xl font-semibold mb-2">Book & Drive</h3>
                    <p class="text-gray-600 text-sm">
                        After approval, you can complete your reservation and enjoy the ride.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">

            <div>
                <h3 class="text-xl font-bold mb-3">Car Rental Laravel</h3>
                <p class="text-gray-400 text-sm">
                    A modern car rental platform built with Laravel, designed for fleet management,
                    customer verification and online reservations.
                </p>
            </div>

            <div>
                <h4 class="font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li><a href="#featured-cars" class="hover:text-white">Featured Cars</a></li>
                    <li><a href="#how-it-works" class="hover:text-white">How It Works</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-3">Customer</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white">My Reservations</a></li>
                    <li><a href="{{ route('customer.document.create') }}" class="hover:text-white">My Document</a>
                    </li>
                    <li><a href="#" class="hover:text-white">Rental Conditions</a></li>
                    <li><a href="#" class="hover:text-white">Support</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-3">Contact</h4>
                <p class="text-gray-400 text-sm">Email: contact@carrental.test</p>
                <p class="text-gray-400 text-sm mt-2">Phone: +40 700 000 000</p>
                <p class="text-gray-400 text-sm mt-2">Piatra Neamț, Romania</p>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-6 mt-10 pt-6 border-t border-gray-800 text-center text-gray-500 text-sm">
            © {{ date('Y') }} Car Rental Laravel. All rights reserved.
        </div>
    </footer>
</body>

</html>

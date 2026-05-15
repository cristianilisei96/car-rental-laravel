<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Car Rental Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 text-gray-900 min-h-screen flex flex-col">

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
                        <a href="{{ route('cars.index') }}" class="hover:underline">Cars</a>

                        <a href="{{ route('customer.favorites.index') }}" class="hover:underline">Favorites</a>

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

    <div class="flex-1">
        {{ $slot }}
    </div>

    <x-public-footer />

</body>

</html>

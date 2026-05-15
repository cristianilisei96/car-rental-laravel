<footer class="bg-black text-white py-12 mt-16">
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
                <li><a href="{{ route('home') }}#featured-cars" class="hover:text-white">Featured Cars</a></li>
                <li><a href="{{ route('home') }}#how-it-works" class="hover:text-white">How It Works</a></li>

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

                @auth
                    <li><a href="{{ route('customer.document.create') }}" class="hover:text-white">My Document</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-white">My Document</a></li>
                @endauth

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

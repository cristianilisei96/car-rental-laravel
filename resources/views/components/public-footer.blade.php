<footer class="bg-white dark:bg-black border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-6 py-14">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Car Rental Laravel
                </h3>

                <p class="mt-4 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    A modern car rental platform built with Laravel, designed for fleet management,
                    customer verification and online reservations.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                    Quick Links
                </h4>

                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cars.index') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Featured Cars
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('home') }}#how-it-works"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            How It Works
                        </a>
                    </li>

                    @auth
                        <li>
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}"
                                class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                Dashboard
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                    Customer
                </h4>

                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <a href="#"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            My Reservations
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('customer.document.create') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            My Document
                        </a>
                    </li>

                    <li>
                        <a href="#"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Rental Conditions
                        </a>
                    </li>

                    <li>
                        <a href="#"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Support
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                    Contact
                </h4>

                <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <li>
                        Email: contact@carrental.test
                    </li>

                    <li>
                        Phone: +40 754 420 138
                    </li>

                    <li>
                        Piatra Neamț, Romania
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <p class="text-center text-sm text-gray-500 dark:text-gray-500">
                © {{ date('Y') }} Car Rental Laravel. All rights reserved.
            </p>
        </div>
    </div>
</footer>

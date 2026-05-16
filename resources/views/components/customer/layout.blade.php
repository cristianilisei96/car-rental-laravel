@props([
    'title' => config('app.name', 'Car Rental Laravel'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <x-customer.navbar />

        @isset($header)
            <header class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-theme-toggle]');

            function updateThemeIcon() {
                const isDark = document.documentElement.classList.contains('dark');

                toggleButtons.forEach((button) => {
                    button.textContent = isDark ? '☀️' : '🌙';
                    button.setAttribute('aria-label', isDark ? 'Switch to light mode' :
                        'Switch to dark mode');
                });
            }

            toggleButtons.forEach((button) => {
                button.addEventListener('click', function() {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    updateThemeIcon();
                });
            });

            updateThemeIcon();
        });
    </script>
</body>

</html>

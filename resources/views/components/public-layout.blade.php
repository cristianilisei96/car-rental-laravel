@props([
    'title' => config('app.name', 'Car Rental Laravel'),
    'navbarVariant' => 'solid',
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

<body class="antialiased bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100 min-h-screen flex flex-col">

    <x-public-navbar :variant="$navbarVariant" />

    <div class="flex-1">
        {{ $slot }}
    </div>

    <x-public-footer />

</body>

</html>

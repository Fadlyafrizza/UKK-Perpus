<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="h-full font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex flex-col min-h-screen">
        <x-navigation />

        <main class="flex-grow">
            <div class="py-6 mx-auto  sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

    </div>

</body>

</html>

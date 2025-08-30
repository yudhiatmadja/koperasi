<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CareMedia') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <!-- Logo CareMedia - TARUH LOGO DI SINI -->
            <div class="mb-6">
                <!-- Ganti dengan path logo CareMedia -->
                <img class="h-16 w-auto"
                     src="{{ asset('images/caremedia-logo.png') }}"
                     alt="CareMedia Logo">

                <!-- Placeholder jika belum ada logo - uncomment yang di bawah dan comment yang di atas -->
                <!-- <div class="h-16 w-16 bg-red-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-xl font-bold">CM</span>
                </div> -->
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500 min-h-screen relative">
        <!-- Decorative SVG background -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none select-none opacity-10 z-0" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="#2563eb" fill-opacity="0.2" d="M0,160L60,170.7C120,181,240,203,360,197.3C480,192,600,160,720,133.3C840,107,960,85,1080,101.3C1200,117,1320,171,1380,197.3L1440,224L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
        </svg>
        <div class="min-h-screen flex flex-col justify-center items-center z-10 relative">
            <div class="mb-4">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-blue-600 drop-shadow-lg" />
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white shadow-2xl border border-blue-100 rounded-2xl relative z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

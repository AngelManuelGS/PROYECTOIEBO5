<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IEBO') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS Personalizado -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Tailwind CSS con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Logo y navegación principal -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6 sm:px-6 lg:px-8">
                <!-- Logo con enlace -->
                <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('dashboard') : route('pedidos')) : route('login') }}" class="flex items-center">
                    <img src="{{ asset('imag/logo-iebo.jpg') }}" alt="IEBO Logo" class="h-12 w-auto">
                    <span class="text-lg font-semibold text-gray-800 dark:text-gray-200 ml-2">IEBO</span>
                </a>

                <!-- Navegación -->
                @include('layouts.navigation')
            </div>
        </header>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="py-10">
            @yield('content')
        </main>
    </div>
</body>
</html>

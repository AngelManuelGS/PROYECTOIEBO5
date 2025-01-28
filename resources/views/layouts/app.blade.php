<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- El atributo 'lang' se establece según la configuración regional de la aplicación Laravel -->

    <head>
        <a href="{{ route('pedidos') }}" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="IEBO Logo" class="h-10">
            <span class="text-lg font-semibold text-gray-800 dark:text-gray-200 ml-2">IEBO</span>

        </a>


        <meta charset="utf-8">

        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        <!-- Configura la codificación de caracteres como UTF-8 -->

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Define el viewport para hacer que el sitio sea responsive -->

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Inserta el token CSRF de Laravel para proteger contra ataques de falsificación de solicitudes -->

        <title>{{ config('app.name', 'IEBO') }}</title>
        <!-- Define el título de la página -->

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <!-- Si usas un archivo .png para el favicon -->
        <!-- <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png"> -->

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Conexión previa y carga de la fuente 'Figtree' desde Bunny Fonts -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Usa Vite para compilar y enlazar los archivos CSS y JS -->
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Logo y navegación principal -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6 sm:px-6 lg:px-8">
                    <!-- Logo con enlace -->
                    <a href="{{ route('pedidos') }}" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="IEBO Logo" class="h-10">
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
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>

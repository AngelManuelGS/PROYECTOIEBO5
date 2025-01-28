<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- Define el idioma de la página basado en la configuración de la aplicación Laravel -->

    <head>
        <meta charset="utf-8">
        <!-- Configura la codificación de caracteres como UTF-8 -->

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Define el viewport para hacer que el sitio sea responsive -->

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Inserta el token CSRF de Laravel para proteger contra ataques de falsificación de solicitudes -->

        <title>{{ config('app.name', 'IEBO') }}</title>
        <!-- Define el título de la página, usando el nombre de la aplicación o "Laravel" como valor predeterminado -->

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

        <!-- Conexión previa y carga de la fuente 'Figtree' desde Bunny Fonts -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Usa Vite para compilar y enlazar los archivos CSS y JS de la aplicación -->
    </head>

    <body class="font-sans text-gray-900 antialiased bg-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">
            <!-- Contenedor principal de la página, centrado vertical y horizontalmente, con fondo adaptable al tema oscuro o claro -->

            <div class="flex justify-center items-center">
                <a href="/">
                    <img src="{{ asset('img/LOGO-IEBO-23A.png') }}" alt="Logo de la plicación" style="width: 750px; height: auto;">
                </a>
            </div>



            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <!-- Contenedor para el contenido de la página (por ejemplo, formularios), estilizado con fondo claro/oscuro, sombra y bordes redondeados -->

                {{ $slot }}
                <!-- Espacio donde se coloca el contenido específico de la página al utilizar esta plantilla -->
            </div>
        </div>
    </body>
</html>

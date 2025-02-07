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
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Swiper.js (CSS) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Establece la imagen de fondo */
        body {
            background: url("{{ asset('img/imagegobierno.png') }}") no-repeat center center fixed;
            background-size: cover;
        }

        /* Carrusel en la parte superior (40% de la pantalla) */
        .swiper-container {
            width: 100%;
            height: 40vh; /* Ocupa el 40% de la pantalla */
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Asegura que la imagen cubra todo el espacio */
        }

        /* Contenedor principal */
        .content-container {
            position: relative; /* Permite que el contenido esté sobre la imagen de fondo */
            z-index: 1; /* Se asegura de que esté por encima del fondo */
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-white">

    <!-- Carrusel en la parte superior -->


    <!-- Contenido principal debajo del carrusel -->
    <div class="content-container flex flex-col items-center mt-10">

        <!-- Logo -->
        <div class="flex justify-center items-center">
            <a href="/">
                <img src="{{ asset('img/LOGO-IEBO-23A.png') }}" alt="Logo de la aplicación" style="width: 750px; height: auto;">
            </a>
        </div>

        <!-- Cuadro del contenido (ejemplo: formulario de inicio de sesión) -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

    </div>


    <!-- Swiper.js (JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper('.swiper-container', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });
        });
    </script>
</body>
</html>

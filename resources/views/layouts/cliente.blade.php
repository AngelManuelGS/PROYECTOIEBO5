<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cliente')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome (Iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])

    <style>
        :root {
            --color-primary: #285C4D;
            --color-secondary: #B38E5D;
            --color-white: #ffffff;
            --color-gray: #f8f9fa;
        }

        /* 🔹 NAVBAR */
        .navbar-custom {
            background-color: var(--color-primary) !important;
        }

        .navbar-custom .nav-link {
            color: var(--color-white) !important;
        }

        /* 🔹 SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--color-primary);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
            color: var(--color-white);
        }

        .sidebar .nav-link {
            color: var(--color-white);
            padding: 10px 15px;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .sidebar .nav-link:hover {
            background: var(--color-secondary);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* 🔹 CONTENIDO PRINCIPAL */
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- 🔹 NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="/">
                <i class="fa fa-book"></i> Catálogo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('carrito.mostrar') }}">
                            <i class="fa fa-shopping-cart"></i> Mi Carrito
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link text-white" type="submit">
                                <i class="fa fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🔹 SIDEBAR -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fa fa-home"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pedidos.index') }}">
                    <i class="fa fa-box"></i> Mis Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('productos.index') }}">
                    <i class="fa fa-book"></i> Productos Disponibles
                </a>
            </li>
        </ul>
    </div>

    <!-- 🔹 CONTENIDO PRINCIPAL -->
    <main class="content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- 🔹 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>

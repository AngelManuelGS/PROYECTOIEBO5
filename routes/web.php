<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompaniaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\AdminVentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran las rutas web para tu aplicación.
| Todas están asignadas al grupo de middleware "web".
*/

// Ruta principal para login
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Grupo de rutas protegidas por middleware 'auth' y 'admin'
Route::middleware(['auth'])->group(function () {
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::prefix('carrito')->group(function () {
        Route::get('/', [CarritoController::class, 'mostrarCarrito'])->name('carrito.mostrar');
        Route::post('/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
        Route::post('/remover/{producto}', [CarritoController::class, 'remover'])->name('carrito.remover');
        Route::post('/comprar', [CarritoController::class, 'finalizarCompra'])->name('carrito.comprar');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');


    // Perfil de usuario
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Recursos principales
    Route::resource('productos', ProductoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('usuarios', UsuarioController::class);

    // Listados para DataTables
    Route::prefix('listar')->group(function () {
        Route::get('productos', [DatatableController::class, 'products'])->name('products.list');
        Route::get('clientes', [DatatableController::class, 'clients'])->name('clients.list');
        Route::get('usuarios', [DatatableController::class, 'users'])->name('users.list');
        Route::get('categorias', [DatatableController::class, 'categories'])->name('categories.list');
        Route::get('ventas', [DatatableController::class, 'sales'])->name('sales.list');
    });

    // Configuración de la compañía
    Route::prefix('compania')->group(function () {
        Route::get('/', [CompaniaController::class, 'index'])->name('compania.index');
        Route::put('/{compania}', [CompaniaController::class, 'update'])->name('compania.update');
    });

    // Ventas para administradores
    Route::prefix('admin/ventas')->group(function () {
        Route::get('/', [AdminVentaController::class, 'index'])->name('ventas.index');
        Route::get('/list', [AdminVentaController::class, 'listarVentas'])->name('ventas.list');
        Route::get('/{id}/estado', [AdminVentaController::class, 'cambiarEstado'])->name('ventas.cambiarEstado');
        Route::get('/{id}/detalles', [AdminVentaController::class, 'detalles'])->name('ventas.detalles');
    });
});

// Grupo de rutas protegidas por middleware 'auth' para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Carrito y ventas
    Route::prefix('carrito')->group(function () {
        Route::get('/', [CarritoController::class, 'mostrarCarrito'])->name('carrito.mostrar');
        Route::post('/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
        Route::post('/remover/{producto}', [CarritoController::class, 'remover'])->name('carrito.remover');
        Route::post('/comprar', [CarritoController::class, 'finalizarCompra'])->name('carrito.comprar');
        Route::get('/pedidos', [VentaController::class, 'misPedidos'])->name('pedidos.index');


    });

    // Ventas
    Route::middleware(['auth'])->group(function () {
        Route::get('/venta/show', [VentaController::class, 'show'])->name('venta.show');
        Route::get('/venta', [VentaController::class, 'index'])->name('venta.index');

        Route::prefix('ventas')->group(function () {
            // Página principal de ventas
            Route::get('/', [VentaController::class, 'index'])->name('venta.index');
        Route::post('/venta', [VentaController::class, 'store'])->name('venta.store');

            // Mostrar ticket de venta
            Route::get('/{id}/ticket', [VentaController::class, 'ticket'])->name('ventas.ticket');

            // Eliminar venta
            Route::delete('/{id}', [VentaController::class, 'destroy'])->name('ventas.eliminar');

            // Editar venta
            Route::get('/{id}/editar', [VentaController::class, 'edit'])->name('ventas.editar');

            // Actualizar venta
            Route::post('/{id}', [VentaController::class, 'update'])->name('ventas.update');

            // Detalles de venta
            Route::get('/{id}/detalles', [VentaController::class, 'detalles'])->name('venta.detalles');
            Route::get('/nueva', [VentaController::class, 'create'])->name('venta.nueva');

            // Listar ventas
            Route::get('/listar', [VentaController::class, 'show'])->name('venta.listar');
            // Mostrar listado de ventas

            // Ruta para método adicional (si es necesario)
            Route::get('/list', [VentaController::class, 'list'])->name('venta.list');

            Route::get('/listarVentas', [DatatableController::class, 'sales'])->name('sales.list');
Route::get('/ventas/{id}/detalles', [VentaController::class, 'detalles'])->name('ventas.detalles');
Route::post('/ventas/{id}/estado', [VentaController::class, 'cambiarEstado'])->name('ventas.cambiarEstado');
Route::get('/listarClientes', [DatatableController::class, 'clients'])->name('clients.list');


        });

        // Buscar cliente en ventas
        Route::get('/venta/cliente', [VentaController::class, 'buscarCliente'])->name('venta.cliente');
    });


    // Cliente en ventas
    Route::get('/cliente/buscar', [ClienteController::class, 'buscar'])->name('cliente.buscar');
});

// Autenticación
require __DIR__ . '/auth.php';

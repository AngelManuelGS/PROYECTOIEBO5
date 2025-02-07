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
use App\Http\Controllers\ProductoVentaController;

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
    Route::get('/pedidos', [CarritoController::class, 'misPedidos'])->name('pedidos.index');
    Route::get('/pedidos', [VentaController::class, 'misPedidos'])->name('pedidos.index');

    Route::get('/pedido', [CarritoController::class, 'mostrarPedidos'])->name('mis.pedidos');
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::prefix('carrito')->group(function () {
        Route::get('/', [CarritoController::class, 'mostrarCarrito'])->name('carrito.mostrar');
        Route::post('/carrito/actualizar/{productoId}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
        Route::post('/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
        Route::post('/remover/{producto}', [CarritoController::class, 'remover'])->name('carrito.remover');
        Route::post('/comprar', [CarritoController::class, 'finalizarCompra'])->name('carrito.comprar');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');



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

    // Ventas
    Route::middleware(['auth'])->group(function () {
        Route::get('/mis-pedidos/{id}/detalles', [VentaController::class, 'detallesCliente'])->name('pedidos.cliente.detalles');
        // Route::get('/mis-pedidos', [VentaController::class, 'misPedidos'])->name('mis.pedidos');


        Route::get('/venta/show', [VentaController::class, 'show'])->name('venta.show');
        Route::get('/venta', [VentaController::class, 'index'])->name('venta.index');

        Route::prefix('ventas')->group(function () {
            // Página principal de ventas
            Route::get('/', [VentaController::class, 'index'])->name('venta.index');
        Route::post('/venta', action: [VentaController::class, 'store'])->name('venta.store');
        Route::post('/venta/store', [VentaController::class, 'store'])->name('venta.store');

            // Mostrar lista de ventas
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
            Route::get('/ventas/{id}/detalles', [VentaController::class, 'detalles'])->name('ventas.detalles');
Route::get('/pedidoS/{id}/ticket', [VentaController::class, 'ticket'])->name('ventas.ticket');
Route::delete('/ventas/{id}/eliminar', [VentaController::class, 'eliminar'])->name('ventas.eliminar');
Route::delete('/ventas/{id}', [VentaController::class, 'destroy'])->name('ventas.eliminar');

            // Listar ventas
            Route::get('/listar', [VentaController::class, 'show'])->name('venta.listar');
            // Mostrar listado de ventas

            // Ruta para método adicional (si es necesario)
            Route::get('/list', [VentaController::class, 'list'])->name('venta.list');

            Route::get('/listarVentas', [DatatableController::class, 'sales'])->name('sales.list');
            Route::get('/ventas/{id}/detalles', [VentaController::class, 'detalles'])->name('ventas.detalles');
            Route::post('/{id}/estado', [VentaController::class, 'cambiarEstado'])->name('ventas.estado');
            Route::get('/listarClientes', [DatatableController::class, 'clients'])->name('clients.list');


        });

        // Buscar cliente en ventas
        Route::get('/venta/cliente', [VentaController::class, 'buscarCliente'])->name('venta.cliente');
    });


    // Cliente en ventas
    Route::get('/cliente/home', [ClienteController::class, 'index'])->name('cliente.home');

    Route::get('/cliente/buscar', [ClienteController::class, 'buscar'])->name('cliente.buscar');

    Route::get('/productosVenta', [ProductoVentaController::class, 'index'])->name('productosVenta.index');
    // Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    // Route::get('/productossinindex', [ProductoController::class, 'index'])->name('productos');
    Route::get('/listarProductos', [DatatableController::class, 'products'])->name('products.list');

// Grupo de rutas accesibles solo para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    Route::get('/pedidos/ticket/{pedido}', [VentaController::class, 'ticket'])
    ->name('ventas.ticket');
    // Ruta para la vista del perfil (disponible para clientes y administradores)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Grupo de rutas solo para clientes
    Route::middleware(['cliente'])->group(function () {
        // Route::get('/mis-pedidos', [PedidosController::class, 'index'])->name('pedidos');
    });

    // Grupo de rutas solo para administradores
    Route::middleware(['admin'])->group(function () {
        // Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });
// **Perfil del usuario**
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// **Carrito de compras**
Route::prefix('carrito')->group(function () {
    Route::get('/', [CarritoController::class, 'mostrarCarrito'])->name('carrito.mostrar');
    Route::post('/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/remover/{producto}', [CarritoController::class, 'remover'])->name('carrito.remover');
    Route::post('/comprar', [CarritoController::class, 'finalizarCompra'])->name('carrito.comprar');




});
Route::middleware(['cliente'])->group(function () {
    // Route::get('/mis-pedidos', [PedidosController::class, 'index'])->name('pedidos');
    Route::get('/pedidos', [CarritoController::class, 'mostrarPedidos'])->name('mis.pedidos');


});

// Página de inicio (puede ser la de login o una pantalla de bienvenida)
// Route::get('/', function () {
//     return view('welcome');
// })->name('home');



});


// Autenticación
require __DIR__ . '/auth.php';

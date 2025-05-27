<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NuevoPedidoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidosController;
use Illuminate\Support\Facades\Auth;

Route::get( '/', function () {
    system("php ../artisan route:list > test.txt");
    if ( ! Auth::check() ) {
        return redirect()->route('login');
    }

    $role = Auth::user()->rol;

    switch ($role) {
        case 'Chef':
            return redirect()->route('home-chef');
        case 'Mesero':
            return redirect()->route('home-mesero');
        case 'Administrador':
            return redirect()->route('home-admin');
    }
});


Route::middleware('guest')->group(function () {
    Route::get( '/login',
        [AuthController::class, 'showLoginForm']
    )->name('login');

    Route::get( '/login',
        [AuthController::class, 'showLoginForm']
    )->name('login');
});


Route::post( '/login',
    [AuthController::class, 'validateUser']
)->name('login.post');


Route::get( '/logout',
    [AuthController::class, 'logout']
)->name('logout');


Route::middleware([CheckRole::class . ':Chef'])->group(function () {
    Route::get('/home-chef', function () {
        return view('pagina-principal-chef');
    })->name('home-chef');
});


Route::middleware([CheckRole::class . ':Mesero'])->group(function () {

    Route::get( '/home-mesero', function () {
        return view('pagina-principal-mesero');
    })->name('home-mesero');


    Route::get( '/ver-mesa/{id}', [MesaController::class, 'verMesa']);


    Route::get( '/categorias/{mesa}',
        [CategoriaController::class, 'index']
    )->name('categorias');

    Route::get( '/categorias2/{mesa}',
        [CategoriaController::class, 'index2']
    )->name('categorias2');

    Route::get( '/categoria/{mesa}/{id}',
        [CategoriaController::class, 'show']
    )->name('productos-categoria');

    Route::get( '/categoria2/{mesa}/{id}',
        [CategoriaController::class, 'show2']
    )->name('productos-categoria2');


    Route::get( '/mesas', [MesaController::class, 'getMesas']);


    Route::view( '/cerrar-cuenta', 'cerrar-cuenta')->name('cerrar-cuenta');
    // Route::view( '/cerrar-cuenta/{mesa}', [PedidosController::class, 'cerrarCuenta'])->name('cerrar-cuenta');


    Route::post( '/agregar-pedido/{mesa}', [PedidosController::class, 'agregarPedido']);
    Route::delete( '/eliminar-pedido/{mesa}', [PedidosController::class, 'eliminarPedido']);
});


Route::middleware([CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/home-admin', function () {
        return view('pagina-principal-admin');
    })->name('home-admin');

    Route::view('/admin-menu', 'admin-menu')->name('admin-menu');

    Route::view('/admin-menu/agregar', 'admin-menu-agregar')->name('admin-menu.agregar');

    Route::view('/admin/desbloquear-usuarios', 'desbloquear-usuarios')->name('admin.desbloquear-usuarios');

    Route::view('/admin/usuarios', 'admin-usuarios')->name('admin.usuarios');

    Route::view('/admin/usuarios/agregar', 'agregar-usuario')->name('admin.usuarios.agregar');

    Route::view('/admin/reporte-ventas', 'reporte-ventas')->name('admin.reporte-ventas');
});

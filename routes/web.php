<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NuevoPedidoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\MesaController;
use Illuminate\Support\Facades\Auth;

Route::get( '/', function () {
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


    Route::get( '/categorias',
        [CategoriaController::class, 'index']
    )->name('categorias.index');


    Route::get( '/categoria/{id}',
        [CategoriaController::class, 'show']
    )->name('categorias.show');


    Route::get( '/nuevo-pedido',
        [NuevoPedidoController::class, 'index']
    )->name('nuevo-pedido');


    Route::get( '/mesas', [MesaController::class, 'getMesas']);


    Route::view( '/cerrar-cuenta', 'cerrar-cuenta')->name('cerrar-cuenta');
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

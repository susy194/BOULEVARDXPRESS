<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NuevoPedidoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidosController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminUsuariosController;
use App\Http\Controllers\CerrarCuentaController;
use App\Http\Controllers\ReporteVentasController;
use App\Http\Controllers\EditarProductoController;

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
    Route::get('/home-chef',[ChefController::class,'CargarPagina'])->name('home-chef');
    Route::get('/api/getmesas',[ChefController::class,'ObtenerComanda']);
    Route::get('/api/actualizarProducto/{id_pedido}/{id_prod}',[ChefController::class,'CambiarEstadoProducto']);
    Route::get('/api/actualizarProducto/{id_pedido}/{id_prod}',[ChefController::class,'EliminarProducto']);
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
    Route::get('/cerrar-cuenta/{num_mesa}', [CerrarCuentaController::class, 'cerrarCuenta'])->name('cerrar-cuenta');
    Route::get('/cerrar-cuenta/{num_mesa}/pdf', [CerrarCuentaController::class, 'generarPDF'])->name('cerrar-cuenta.pdf');


    Route::post( '/agregar-pedido/{mesa}', [PedidosController::class, 'agregarPedido']);
    Route::delete( '/eliminar-pedido/{mesa}', [PedidosController::class, 'eliminarPedido']);

    Route::post('/editar-producto', [EditarProductoController::class, 'editar'])->name('editar-producto');
});


Route::middleware([CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/home-admin', function () {
        return view('pagina-principal-admin');
    })->name('home-admin');

    Route::get('/admin-menu', [AdminMenuController::class, 'index'])->name('admin.menu');

    Route::get('/admin-menu/agregar', [AdminMenuController::class, 'create'])->name('admin-menu.agregar');

    Route::post('/admin-menu/agregar', [App\Http\Controllers\AdminMenuController::class, 'store'])->name('admin-menu.store');

    Route::get('/admin/desbloquear-usuarios', [App\Http\Controllers\AdminUsuariosController::class, 'desbloquearUsuarios'])->name('admin.desbloquear-usuarios');

    Route::post('/admin/toggle-bloqueo', [App\Http\Controllers\AdminUsuariosController::class, 'toggleBloqueo'])->name('admin.toggle-bloqueo');

    Route::get('/admin/usuarios', [AdminUsuariosController::class, 'index'])->name('admin-usuarios');

    Route::get('/admin/usuarios/agregar', [AdminUsuariosController::class, 'create'])->name('admin-usuarios-agregar');

    Route::post('/admin/usuarios/store', [AdminUsuariosController::class, 'store'])->name('admin-usuarios.store');

    Route::delete('/admin-menu/producto/{id}', [AdminMenuController::class, 'eliminarProducto'])->name('admin-menu.eliminar-producto');

    Route::post('/admin-menu/producto/{id}/precio', [AdminMenuController::class, 'actualizarPrecio'])->name('admin-menu.actualizar-precio');

    Route::delete('/admin/usuarios/{id}', [AdminUsuariosController::class, 'eliminarUsuario'])->name('admin.usuarios.eliminar');

    Route::get('/admin/reporte-ventas/generar', [ReporteVentasController::class, 'generarPDF'])->name('admin.reporte-ventas.generar');
});

Route::get('storage/app/temp/{filename}', function ($filename) {
    $path = storage_path('app/temp/' . $filename);
    if (file_exists($path)) {
        return response()->download($path)->deleteFileAfterSend(true);
    }
    abort(404);
});

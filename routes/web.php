<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\LoteProductoController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\LoteInsumoController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// LOGIN ROUTES
Route::get('/', function () {
    return redirect('/login');
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// REGISTRATION ROUTES
Route::middleware('auth')->group(function () {
    // Solo los usuarios autenticados pueden crear otros usuarios
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
// Deshabilitar posibilidad de registro público
Auth::routes(['register' => false]);


// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/ventas-por-anio', [DashboardController::class, 'ventasPorAnio'])->middleware('auth')->name('dashboard.ventasPorAnio');
Route::get('/dashboard/productos-mas-vendidos', [DashboardController::class, 'productosMasVendidosFiltrados'])->middleware('auth')->name('dashboard.productosMasVendidosFiltrados');


// LOTES DE INSUMOS ROUTES
Route::get('/insumos/lotes/infoStock', [LoteInsumoController::class, 'infoStock'])->middleware('auth')->name('lotes.infoStock');
Route::get('/insumos/lotes/vencidos', [LoteInsumoController::class, 'vencidos'])->middleware('auth')->name('lotes.infoVencimientos');
Route::delete('/insumos/lotes/eliminar/{lote}', [LoteInsumoController::class, 'eliminar'])->middleware('auth')->name('lotes.destroy');

// INSUMOS ROUTES
Route::get('/insumos', [InsumoController::class, 'insumos'])->middleware('auth')->name('insumos.estante');
Route::get('/insumos/create', [InsumoController::class, 'create'])->middleware('auth')->name('insumos.create');
Route::post('/insumos/store', [InsumoController::class, 'store'])->middleware('auth')->name('insumos.store');
Route::get('/insumos/historial', [InsumoController::class, 'historial'])->middleware('auth')->name('insumos.historial');
Route::get('/insumos/lotes/{insumo}', [InsumoController::class, 'lotes'])->middleware('auth')->name('insumos.lotes');
Route::get('/insumos/edit/{insumo}', [InsumoController::class, 'edit'])->middleware('auth')->name('insumos.edit');
Route::put('/insumos/update/{insumo}', [InsumoController::class, 'update'])->middleware('auth')->name('insumos.update');
Route::get('/insumos/reponer/{insumo}', [InsumoController::class, 'reponer'])->middleware('auth')->name('insumos.reponer');
Route::post('/insumos/reponer/{insumo}', [InsumoController::class, 'reponerStore'])->middleware('auth')->name('insumos.reponer.store');
Route::delete('/insumos/eliminar/{insumo}', [InsumoController::class, 'eliminar'])->middleware('auth')->name('insumos.destroy');
Route::get('/insumos/eliminados', [InsumoController::class, 'eliminados'])->middleware('auth')->name('insumos.eliminados');
Route::get('/insumos/restore/{idInsumo}', [InsumoController::class, 'restore'])->middleware('auth')->name('insumos.restore');
Route::get('/insumos/{idFamilia}', [InsumoController::class, 'porFamilia'])->middleware('auth')->name('insumos.porFamilia');

// FAMILIAS ROUTES
Route::post('/familias/store', [FamiliaController::class, 'store'])->middleware('auth')->name('familias.store');


// PRODUCTOS ROUTES
Route::get('/productos', [ProductoController::class, 'productos'])->middleware('auth')->name('productos.estante');
Route::get('/productos/create', [ProductoController::class, 'create'])->middleware('auth')->name('productos.create');
Route::post('/productos/store', [ProductoController::class, 'store'])->middleware('auth')->name('productos.store');
Route::get('/productos/edit/{producto}', [ProductoController::class, 'edit'])->middleware('auth')->name('productos.edit');
Route::put('/productos/update/{producto}', [ProductoController::class, 'update'])->middleware('auth')->name('productos.update');
Route::get('/productos/lotes/{producto}', [ProductoController::class, 'lotes'])->middleware('auth')->name('productos.lotes');
Route::get('/productos/showFormula/{producto}', [ProductoController::class, 'showFormula'])->middleware('auth')->name('productos.showFormula');
Route::get('/productos/reponer/{producto}', [ProductoController::class, 'reponer'])->middleware('auth')->name('productos.reponer');
Route::post('/productos/reponer/{producto}', [ProductoController::class, 'reponerStore'])->middleware('auth')->name('productos.reponer.store');
Route::delete('/productos/eliminar/{producto}', [ProductoController::class, 'eliminar'])->middleware('auth')->name('productos.destroy');
Route::get('/productos/eliminados', [ProductoController::class, 'eliminados'])->middleware('auth')->name('productos.eliminados');
Route::get('/productos/restore/{idProducto}', [ProductoController::class, 'restore'])->middleware('auth')->name('productos.restore');

// LOTES DE PRODUCTOS ROUTES
Route::get('/productos/historial', [LoteProductoController::class, 'historial'])->middleware('auth')->name('productos.historial');
Route::delete('/productos/lotes/eliminar/{lote}', [LoteProductoController::class, 'eliminar'])->middleware('auth')->name('loteProducto.destroy');


// VENTAS ROUTES
Route::get('/ventas', [VentaController::class, 'ventas'])->middleware('auth')->name('ventas.index');
Route::get('/productos/buscar', [VentaController::class, 'buscar']);
Route::post('/ventas/store', [VentaController::class, 'store'])->middleware('auth')->name('ventas.store');
Route::get('/ventas/historial', [VentaController::class, 'historial'])->middleware('auth')->name('ventas.historial');


// MANUAL ROUTES
Route::get('/manual/descargar', [ManualController::class, 'descargar'])->middleware('auth')->name('manual.descargar');


// USER PROFILE ROUTES
Route::get('/profile', [UserController::class, 'show'])->middleware('auth')->name('profile');
Route::put('/profile', [UserController::class, 'update'])->middleware('auth')->name('profile.update');







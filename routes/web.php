<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\LoteInsumoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HistorialController;
use Illuminate\Support\Facades\Route;

//LOGIN ROUTES
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

//INSUMOS ROUTES
Route::get('/insumos', [InsumoController::class, 'insumos'])->middleware('auth')->name('insumos.estante');
Route::get('/insumos/create', [InsumoController::class, 'create'])->middleware('auth')->name('insumos.create');
Route::post('/insumos/store', [InsumoController::class, 'store'])->middleware('auth')->name('insumos.store');
Route::get('/insumos/edit/{insumo}', [InsumoController::class, 'edit'])->middleware('auth')->name('insumos.edit');
Route::put('/insumos/update/{insumo}', [InsumoController::class, 'update'])->middleware('auth')->name('insumos.update');
Route::get('/insumos/reponer/{insumo}', [InsumoController::class, 'reponer'])->middleware('auth')->name('insumos.reponer');
Route::post('/insumos/reponer/{insumo}', [InsumoController::class, 'reponerStore'])->middleware('auth')->name('insumos.reponer.store');
Route::put('/insumos/deshabilitar/{insumo}', [InsumoController::class, 'deshabilitar'])->middleware('auth')->name('insumos.deshabilitar');
Route::get('/insumos/{idFamilia}', [InsumoController::class, 'porFamilia'])->middleware('auth')->name('insumos.porFamilia');


//FAMILIAS ROUTES
Route::post('/familias/store', [FamiliaController::class, 'store'])->middleware('auth')->name('familias.store');


//LOTES ROUTES
Route::get('/lotes/infoStock', [LoteInsumoController::class, 'infoStock'])->middleware('auth')->name('lotes.infoStock');
Route::get('/lotes/vencidos', [LoteInsumoController::class, 'vencidos'])->middleware('auth')->name('lotes.infoVencimientos');
Route::get('/lotes/{insumo}', [LoteInsumoController::class, 'showLotes'])->middleware('auth')->name('lotes.show');


//PRODUCTOS ROUTES
Route::get('/productos', [ProductoController::class, 'productos'])->middleware('auth')->name('productos.estante');
Route::get('/productos/create', [ProductoController::class, 'create'])->middleware('auth')->name('productos.create');
Route::post('/productos/store', [ProductoController::class, 'store'])->middleware('auth')->name('productos.store');
Route::get('/productos/edit/{producto}', [ProductoController::class, 'edit'])->middleware('auth')->name('productos.edit');
Route::put('/productos/update/{producto}', [ProductoController::class, 'update'])->middleware('auth')->name('productos.update');
Route::get('/productos/historial/{producto}', [ProductoController::class, 'historial'])->middleware('auth')->name('productos.historial');
Route::get('/productos/showFormula/{producto}', [ProductoController::class, 'showFormula'])->middleware('auth')->name('productos.showFormula');
Route::get('/productos/reponer/{producto}', [ProductoController::class, 'reponer'])->middleware('auth')->name('productos.reponer');
Route::post('/productos/reponer/{producto}', [ProductoController::class, 'reponerStore'])->middleware('auth')->name('productos.reponer.store');

//HISTORIAL ROUTES
Route::get('/historial', [HistorialController::class, 'historial'])->middleware('auth')->name('historial.general');
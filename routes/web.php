<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\LoteInsumoController;
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

//FAMILIAS ROUTES
Route::get('/familias/create', [FamiliaController::class, 'create'])->middleware('auth')->name('familias.create');
Route::post('/familias/store', [FamiliaController::class, 'store'])->middleware('auth')->name('familias.store');


//LOTES ROUTES
Route::get('/lotes/{insumo}', [LoteInsumoController::class, 'showLotes'])->middleware('auth')->name('lotes.show');
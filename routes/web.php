<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', DashboardController::class)->name('dashboard');

Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('', [KategoriController::class, 'index'])->name('index');
    Route::get('tambah', [KategoriController::class, 'create'])->name('create');
    Route::post('', [KategoriController::class, 'store'])->name('store');
    Route::get('edit/{kategori:slug}', [KategoriController::class, 'edit'])->name('edit');
    Route::put('{kategori:slug}', [KategoriController::class, 'update'])->name('update');
    Route::delete('{kategori:slug}', [KategoriController::class, 'destroy'])->name('destroy');
});

Route::prefix('kelas')->name('kelas.')->group(function () {
    Route::get('', [KelasController::class, 'index'])->name('index');
    Route::get('tambah', [KelasController::class, 'create'])->name('create');
    Route::post('', [KelasController::class, 'store'])->name('store');
    Route::get('edit/{kelas:slug}', [KelasController::class, 'edit'])->name('edit');
    Route::put('{kelas:slug}', [KelasController::class, 'update'])->name('update');
    Route::delete('{kelas:slug}', [KelasController::class, 'destroy'])->name('destroy');
});

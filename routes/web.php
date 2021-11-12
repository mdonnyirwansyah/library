<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
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

Route::prefix('kelas')->name('kelas.')->group(function () {
    Route::get('', [KelasController::class, 'index'])->name('index');
    Route::get('create', [KelasController::class, 'create'])->name('create');
    Route::post('', [KelasController::class, 'store'])->name('store');
    Route::get('edit/{kelas:slug}', [KelasController::class, 'edit'])->name('edit');
    Route::put('{kelas:slug}', [KelasController::class, 'update'])->name('update');
    Route::delete('{kelas:slug}', [KelasController::class, 'destroy'])->name('destroy');
});

Route::prefix('anggota')->name('anggota.')->group(function () {
    Route::get('', [AnggotaController::class, 'index'])->name('index');
    Route::get('create', [AnggotaController::class, 'create'])->name('create');
    Route::post('', [AnggotaController::class, 'store'])->name('store');
    Route::post('find', [AnggotaController::class, 'find'])->name('find');
    Route::get('edit/{anggota:slug}', [AnggotaController::class, 'edit'])->name('edit');
    Route::put('{anggota:slug}', [AnggotaController::class, 'update'])->name('update');
    Route::delete('{anggota:slug}', [AnggotaController::class, 'destroy'])->name('destroy');
});

Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('', [KategoriController::class, 'index'])->name('index');
    Route::get('create', [KategoriController::class, 'create'])->name('create');
    Route::post('', [KategoriController::class, 'store'])->name('store');
    Route::get('edit/{kategori:slug}', [KategoriController::class, 'edit'])->name('edit');
    Route::put('{kategori:slug}', [KategoriController::class, 'update'])->name('update');
    Route::delete('{kategori:slug}', [KategoriController::class, 'destroy'])->name('destroy');
});

Route::prefix('buku')->name('buku.')->group(function () {
    Route::get('', [BukuController::class, 'index'])->name('index');
    Route::get('create', [BukuController::class, 'create'])->name('create');
    Route::post('', [BukuController::class, 'store'])->name('store');
    Route::get('edit/{buku:slug}', [BukuController::class, 'edit'])->name('edit');
    Route::put('{buku:slug}', [BukuController::class, 'update'])->name('update');
    Route::delete('{buku:slug}', [BukuController::class, 'destroy'])->name('destroy');
});

Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
    Route::get('', [PeminjamanController::class, 'index'])->name('index');
    Route::get('create', [PeminjamanController::class, 'create'])->name('create');
    Route::post('', [PeminjamanController::class, 'store'])->name('store');
    Route::post('find', [PeminjamanController::class, 'find'])->name('find');
    Route::get('show/{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
    Route::get('edit/{peminjaman}', [PeminjamanController::class, 'edit'])->name('edit');
    Route::put('{peminjaman}', [PeminjamanController::class, 'update'])->name('update');
    Route::delete('{peminjaman}', [PeminjamanController::class, 'destroy'])->name('destroy');
});

Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
    Route::get('', [PengembalianController::class, 'index'])->name('index');
    Route::get('create', [PengembalianController::class, 'create'])->name('create');
    Route::post('', [PengembalianController::class, 'store'])->name('store');
    Route::get('edit/{pengembalian}', [PengembalianController::class, 'edit'])->name('edit');
    Route::put('{pengembalian}', [PengembalianController::class, 'update'])->name('update');
    Route::delete('{pengembalian}', [PengembalianController::class, 'destroy'])->name('destroy');
});

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('anggota', [LaporanController::class, 'anggota'])->name('anggota');
    Route::post('get-anggota', [LaporanController::class, 'getAnggotaData'])->name('get-anggota');
    Route::get('buku', [LaporanController::class, 'buku'])->name('buku');
    Route::post('get-buku', [LaporanController::class, 'getBukuData'])->name('get-buku');
    Route::get('peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
    Route::get('pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
});


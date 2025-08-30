<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('simpanan', \App\Http\Controllers\Admin\SimpananController::class);
    Route::resource('piutang', \App\Http\Controllers\Admin\PiutangController::class);
    Route::resource('anggota', \App\Http\Controllers\Admin\AnggotaController::class);
    Route::resource('proyek', \App\Http\Controllers\Admin\ProyekController::class);

    // TAHAPAN PROYEK - Gunakan route yang konsisten
    Route::put('tahapan-proyek/{tahapan}', [\App\Http\Controllers\Admin\TahapanProyekController::class, 'update'])->name('tahapan-proyek.update');
    Route::delete('tahapan/{tahapan}', [\App\Http\Controllers\Admin\TahapanProyekController::class, 'destroy'])->name('tahapan.destroy');
    Route::post('proyek/{proyek}/tahapan', [\App\Http\Controllers\Admin\TahapanProyekController::class, 'store'])->name('proyek.tahapan.store');

    // TAGIHAN PROYEK
    Route::post('proyek/{proyek}/tagihan', [\App\Http\Controllers\Admin\TagihanProyekController::class, 'store'])->name('proyek.tagihan.store');
    Route::get('tagihan/{tagihan}/edit', [\App\Http\Controllers\Admin\TagihanProyekController::class, 'edit'])->name('tagihan.edit');
    Route::put('tagihan/{tagihan}', [\App\Http\Controllers\Admin\TagihanProyekController::class, 'update'])->name('tagihan.update');
    Route::delete('tagihan/{tagihan}', [\App\Http\Controllers\Admin\TagihanProyekController::class, 'destroy'])->name('tagihan.destroy');

    // BIAYA PROYEK
    Route::post('proyek/{proyek}/biaya', [\App\Http\Controllers\Admin\BiayaProyekController::class, 'store'])->name('proyek.biaya.store');
    Route::get('biaya/{biaya}/edit', [\App\Http\Controllers\Admin\BiayaProyekController::class, 'edit'])->name('biaya.edit');
    Route::put('biaya/{biaya}', [\App\Http\Controllers\Admin\BiayaProyekController::class, 'update'])->name('biaya.update');
    Route::delete('biaya/{biaya}', [\App\Http\Controllers\Admin\BiayaProyekController::class, 'destroy'])->name('biaya.destroy');

    Route::resource('pinjaman', \App\Http\Controllers\Admin\PinjamanController::class);

    Route::post('pinjaman/{pinjaman}/angsuran', [\App\Http\Controllers\Admin\TransaksiPiutangController::class, 'storeAngsuran'])->name('pinjaman.angsuran.store');

Route::get('laporan/piutang', [\App\Http\Controllers\Admin\LaporanPiutangController::class, 'index'])->name('laporan.piutang.index');
Route::get('transaksi-piutang/{transaksi}/edit', [\App\Http\Controllers\Admin\TransaksiPiutangController::class, 'edit'])->name('transaksi-piutang.edit');
Route::put('transaksi-piutang/{transaksi}', [\App\Http\Controllers\Admin\TransaksiPiutangController::class, 'update'])->name('transaksi-piutang.update');
Route::delete('transaksi-piutang/{transaksi}', [\App\Http\Controllers\Admin\TransaksiPiutangController::class, 'destroy'])->name('transaksi-piutang.destroy');


});
require __DIR__ . '/auth.php';

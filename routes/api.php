<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberDataController;

// RUTE OTENTIKASI (PUBLIC)
Route::post('/login', [AuthController::class, 'login']);

// RUTE YANG DILINDUNGI
Route::middleware('auth:sanctum')->group(function () {
    // Otentikasi
    Route::get('/user', fn(Request $request) => new \App\Http\Resources\UserResource($request->user()));
    Route::post('/logout', [AuthController::class, 'logout']);

    // Data Koperasi Anggota
    Route::get('/dashboard', [MemberDataController::class, 'dashboard']);
    Route::get('/simpanan', [MemberDataController::class, 'simpanan']);
    Route::get('/piutang', [MemberDataController::class, 'piutangList']);
    Route::get('/piutang/{pinjaman}', [MemberDataController::class, 'piutangDetail']);

    // Data Proyek (Read-Only)
    Route::get('/proyek', [MemberDataController::class, 'proyekList']);
    Route::get('/proyek/{proyek}', [MemberDataController::class, 'proyekDetail']);

    Route::get('/piutang/{pinjaman}/ringkasan', [MemberDataController::class, 'piutangRingkasanBulanan']);
    
});

<?php

namespace App\Observers;

use App\Models\SimpananBulanan;
use Carbon\Carbon;

class SimpananBulananObserver
{
    // Dipanggil SEBELUM data baru disimpan
    public function creating(SimpananBulanan $simpananBulanan): void
    {
        // 1. Tentukan saldo awal
        $periode_sebelumnya = Carbon::createFromFormat('Y-m', $simpananBulanan->periode)->subMonth()->format('Y-m');

        $simpanan_sebelumnya = SimpananBulanan::where('nik', $simpananBulanan->nik)
                                             ->where('periode', $periode_sebelumnya)
                                             ->first();

        $simpananBulanan->saldo_awal = $simpanan_sebelumnya ? $simpanan_sebelumnya->saldo_akhir : 0;

        // 2. Hitung saldo akhir
        $penambahan = $simpananBulanan->total_pokok + $simpananBulanan->total_wajib + $simpananBulanan->total_sukarela;
        $pengurangan = $simpananBulanan->total_penarikan;

        $simpananBulanan->saldo_akhir = $simpananBulanan->saldo_awal + $penambahan - $pengurangan;
    }

    // Dipanggil SEBELUM data yang ada di-update
    public function updating(SimpananBulanan $simpananBulanan): void
    {
        // Saat update, saldo awal tidak boleh berubah, kita hanya hitung ulang saldo akhir
        $penambahan = $simpananBulanan->total_pokok + $simpananBulanan->total_wajib + $simpananBulanan->total_sukarela;
        $pengurangan = $simpananBulanan->total_penarikan;

        $simpananBulanan->saldo_akhir = $simpananBulanan->saldo_awal + $penambahan - $pengurangan;
    }
}

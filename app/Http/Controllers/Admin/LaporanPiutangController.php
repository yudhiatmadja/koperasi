<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanPiutangController extends Controller
{
    public function index(Request $request)
    {
        // Tentukan periode laporan
        $periodeInput = $request->input('periode', now()->format('Y-m'));
        $periode = Carbon::createFromFormat('Y-m', $periodeInput);
        $startOfMonth = $periode->copy()->startOfMonth();
        $endOfMonth = $periode->copy()->endOfMonth();
        $endOfPreviousMonth = $periode->copy()->subMonth()->endOfMonth();

        // Ambil semua pinjaman yang aktif sebelum akhir periode laporan
        $pinjamans = Pinjaman::where('tanggal_pinjaman', '<=', $endOfMonth)->get();

        $laporanData = [];
        foreach ($pinjamans as $pinjaman) {
            // 1. Hitung Saldo Awal (Saldo di akhir bulan sebelumnya)
            $mutasiPlusSebelumnya = $pinjaman->transaksi()
                ->where('tanggal_transaksi', '<=', $endOfPreviousMonth)
                ->sum('jumlah_pinjaman_baru');

            $mutasiMinusSebelumnya = $pinjaman->transaksi()
                ->where('tanggal_transaksi', '<=', $endOfPreviousMonth)
                ->sum('bayar_pokok');

            $saldoAwal = $mutasiPlusSebelumnya - $mutasiMinusSebelumnya;

            // 2. Ambil Mutasi di bulan ini
            $mutasiBulanIni = $pinjaman->transaksi()
                ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
                ->get();

            $totalMutasiPlusBulanIni = $mutasiBulanIni->sum('jumlah_pinjaman_baru');
            $totalMutasiMinusPokokBulanIni = $mutasiBulanIni->sum('bayar_pokok');
            $totalMutasiMinusBungaBulanIni = $mutasiBulanIni->sum('bayar_bunga');

            // 3. Hitung Saldo Akhir
            $saldoAkhir = $saldoAwal + $totalMutasiPlusBulanIni - $totalMutasiMinusPokokBulanIni;

            // Jangan tampilkan pinjaman yang sudah lunas sebelum periode ini
            if ($saldoAwal <= 0 && $mutasiBulanIni->isEmpty()) {
                continue;
            }

            $laporanData[] = [
                'nama' => $pinjaman->nama_peminjam,
                'saldo_awal' => $saldoAwal,
                'mutasi_plus' => $mutasiBulanIni->where('jumlah_pinjaman_baru', '>', 0)->first(),
                'mutasi_minus' => $mutasiBulanIni->where('bayar_pokok', '>', 0)->first(),
                'total_bunga_bulan_ini' => $totalMutasiMinusBungaBulanIni,
                'saldo_akhir' => $saldoAkhir,
            ];
        }

        return view('admin.laporan.piutang', [
            'laporanData' => $laporanData,
            'periode' => $periode,
        ]);
    }
}

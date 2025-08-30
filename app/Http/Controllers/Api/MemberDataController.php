<?php

namespace App\Http\Controllers\Api;

use App\Models\Proyek;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use App\Models\SimpananBulanan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProyekResource;
use App\Http\Resources\PinjamanResource;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\SimpananBulananResource;

class MemberDataController extends Controller
{
    /**
     * Mengembalikan ringkasan data untuk dasbor anggota.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $totalSimpanan = SimpananBulanan::where('nik', $user->nik)
            ->latest('periode')
            ->first()->saldo_akhir ?? 0;

        $sisaPinjaman = Pinjaman::where('user_nik', $user->nik)
            ->where('status', 'BELUM LUNAS')
            ->sum('sisa_pokok_pinjaman');

        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $user->name,
                'total_simpanan' => (int) $totalSimpanan,
                'sisa_pinjaman' => (int) $sisaPinjaman,
            ]
        ]);
    }

    /**
     * Mengembalikan riwayat simpanan anggota.
     */
    public function simpanan(Request $request)
    {
        $simpanan = SimpananBulanan::where('nik', $request->user()->nik)
            ->orderBy('periode', 'desc')
            ->paginate(12);

        return SimpananBulananResource::collection($simpanan);
    }

    /**
 * Mengembalikan daftar pinjaman anggota.
 */
public function piutangList(Request $request)
{
    $user = $request->user();

    // Debug: Cek data user
    Log::info('User data:', [
        'id' => $user->id,
        'nik' => $user->nik,
        'name' => $user->name
    ]);

    // Debug: Cek total pinjaman dengan NIK ini
    $totalPinjaman = Pinjaman::where('user_nik', $user->nik)->count();
    Log::info('Total pinjaman untuk NIK ' . $user->nik . ': ' . $totalPinjaman);

    // Debug: Cek semua data pinjaman untuk debugging
    $allPinjaman = Pinjaman::where('user_nik', $user->nik)->get();
    Log::info('Data pinjaman:', $allPinjaman->toArray());

    $pinjaman = Pinjaman::where('user_nik', $user->nik)
        ->latest('tanggal_pinjaman')
        ->paginate(10);

    Log::info('Paginated result count: ' . $pinjaman->count());

    return PinjamanResource::collection($pinjaman);
}

    /**
     * Mengembalikan detail dan riwayat transaksi dari satu pinjaman.
     */
    public function piutangDetail(Request $request, Pinjaman $pinjaman)
    {
        // Keamanan: Pastikan anggota hanya bisa melihat pinjamannya sendiri
        if ($pinjaman->user_nik !== $request->user()->nik) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pinjaman->load('transaksi');
        return new PinjamanResource($pinjaman);
    }

    /**
     * Mengembalikan daftar semua proyek (read-only).
     */
    public function proyekList()
    {
        $proyek = Proyek::latest('tanggal_proyek')
            ->select('id', 'nama_pekerjaan', 'nomor_proyek', 'tanggal_mulai', 'tanggal_selesai')
            ->paginate(10);

        return ProyekResource::collection($proyek);
    }

    /**
     * Mengembalikan detail lengkap satu proyek.
     */
    public function proyekDetail(Proyek $proyek)
    {
        $proyek->load(['tahapans', 'tagihans', 'biayas']);
        return new ProyekResource($proyek);
    }

    // app/Http/Controllers/Api/MemberDataController.php
public function piutangRingkasanBulanan(Request $request, Pinjaman $pinjaman)
{
    // Keamanan
    if ($pinjaman->user_nik !== $request->user()->nik) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $request->validate(['periode' => 'required|date_format:Y-m']);

    // Logika kalkulasi mirip dengan LaporanPiutangController
    $periode = \Carbon\Carbon::createFromFormat('Y-m', $request->periode);
    $startOfMonth = $periode->copy()->startOfMonth();
    $endOfMonth = $periode->copy()->endOfMonth();
    $endOfPreviousMonth = $periode->copy()->subMonth()->endOfMonth();

    $mutasiPlusSebelumnya = $pinjaman->transaksi()->where('tanggal_transaksi', '<=', $endOfPreviousMonth)->sum('jumlah_pinjaman_baru');
    $mutasiMinusSebelumnya = $pinjaman->transaksi()->where('tanggal_transaksi', '<=', $endOfPreviousMonth)->sum('bayar_pokok');
    $saldoAwal = $mutasiPlusSebelumnya - $mutasiMinusSebelumnya;

    $transaksiBulanIni = $pinjaman->transaksi()->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])->get();
    $saldoAkhir = $saldoAwal + $transaksiBulanIni->sum('jumlah_pinjaman_baru') - $transaksiBulanIni->sum('bayar_pokok');

    return response()->json([
        'data' => [
            'periode' => $periode->format('F Y'),
            'saldo_awal' => (int) $saldoAwal,
            'transaksi_bulan_ini' => \App\Http\Resources\TransaksiPiutangResource::collection($transaksiBulanIni),
            'saldo_akhir' => (int) $saldoAkhir,
        ]
    ]);
}
}

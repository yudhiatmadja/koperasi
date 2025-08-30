<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Models\Proyek;
use App\Models\SimpananBulanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor admin beserta data statistiknya
     */
    public function index()
    {
        // 1. Statistik Total Anggota (Tetap sama)
        $totalAnggota = User::where('role', 'member')->count();

        // 2. STATISTIK DIUBAH: Menghitung total baris/record di tabel simpanan
        $jumlahTransaksiSimpanan = SimpananBulanan::count();

        // 3. STATISTIK DIUBAH: Menghitung jumlah pinjaman yang statusnya 'BELUM LUNAS'
        $jumlahPinjamanAktif = Pinjaman::where('status', 'BELUM LUNAS')->count();

        // 4. Statistik Proyek Aktif (Tetap sama)
        $proyekAktif = Proyek::where('tanggal_selesai', '>=', now())->count();

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalAnggota',
            'jumlahTransaksiSimpanan', // Variabel diganti
            'jumlahPinjamanAktif',     // Variabel diganti
            'proyekAktif'
        ));
    }
}

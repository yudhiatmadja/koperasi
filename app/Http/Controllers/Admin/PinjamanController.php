<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    // Menampilkan daftar semua pinjaman
    public function index()
    {
        $pinjamans = Pinjaman::with('user')->latest()->paginate(15);
        return view('admin.pinjaman.index', compact('pinjamans'));
    }

    // Menampilkan form untuk membuat pinjaman baru
    public function create()
    {
        $anggota = User::where('role', 'member')->orderBy('name')->get();
        return view('admin.pinjaman.create', compact('anggota'));
    }

    // Menyimpan pinjaman baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_nik' => 'required_if:peminjamType,anggota|nullable|exists:users,nik',
        'nama_peminjam_non_anggota' => 'required_if:peminjamType,non_anggota|nullable|string|max:255',
            'tanggal_pinjaman' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric|min:1000',
            'jangka_waktu_bulan' => 'required|integer|min:1',
        ]);

        $user = User::where('nik', $validated['user_nik'])->firstOrFail();

        DB::transaction(function () use ($validated, $user) {
            $pinjaman = Pinjaman::create([
                'user_nik' => $validated['user_nik'] ?? null,
        'nama_peminjam_non_anggota' => $validated['nama_peminjam_non_anggota'] ?? null,
                'tanggal_pinjaman' => $validated['tanggal_pinjaman'],
                'jumlah_pinjaman' => $validated['jumlah_pinjaman'],
                'jangka_waktu_bulan' => $validated['jangka_waktu_bulan'],
                'sisa_pokok_pinjaman' => $validated['jumlah_pinjaman'],
                'status' => 'BELUM LUNAS',
            ]);

            $pinjaman->transaksi()->create([
                'nik' => $validated['user_nik'],
                'nama' => $user->name,
                'tanggal_transaksi' => $validated['tanggal_pinjaman'],
                'keterangan' => 'Pencairan Pinjaman Baru',
                'jumlah_pinjaman_baru' => $validated['jumlah_pinjaman'],
            ]);
        });

        return redirect()->route('admin.pinjaman.index')->with('success', 'Pinjaman baru berhasil ditambahkan.');
    }

    // Menampilkan detail 1 pinjaman
    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load('user', 'transaksi');
        return view('admin.pinjaman.show', compact('pinjaman'));
    }

    // Menampilkan form edit pinjaman
    public function edit(Pinjaman $pinjaman)
    {
        $anggota = User::where('role', 'member')->orderBy('name')->get();
        return view('admin.pinjaman.edit', compact('pinjaman', 'anggota'));
    }

    // Update data pinjaman
    public function update(Request $request, Pinjaman $pinjaman)
{
    $validated = $request->validate([
        'tanggal_pinjaman' => 'required|date',
        'jumlah_pinjaman' => 'required|numeric|min:1000',
        'jangka_waktu_bulan' => 'required|integer|min:1',
        'sisa_pokok_pinjaman' => 'required|numeric|min:0|lte:jumlah_pinjaman',
        'status' => 'required|in:BELUM LUNAS,LUNAS',
    ]);

    $pinjaman->update($validated);

    return redirect()->route('admin.pinjaman.index')->with('success', 'Data pinjaman berhasil diperbarui.');
}

    // Menghapus pinjaman
    public function destroy(Pinjaman $pinjaman)
    {
        $pinjaman->delete();
        return redirect()->route('admin.pinjaman.index')->with('success', 'Pinjaman dan riwayat transaksinya berhasil dihapus.');
    }
}

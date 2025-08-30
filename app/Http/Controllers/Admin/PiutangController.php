<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPiutang;
use App\Models\User;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    public function index()
    {
        $piutang = TransaksiPiutang::latest()->paginate(15);
        return view('admin.piutang.index', compact('piutang'));
    }

    public function create()
    {
        $anggota = User::where('role', 'member')->orderBy('name')->get();
        return view('admin.piutang.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'jumlah_pinjaman_baru' => 'nullable|numeric|min:0',
            'jangka_waktu_bulan' => 'nullable|integer|min:0',
            'bayar_pokok' => 'nullable|numeric|min:0',
            'bayar_bunga' => 'nullable|numeric|min:0',
            'id_pinjaman' => 'nullable|integer|exists:transaksi_piutangs,id',
        ]);

        $user = User::where('nik', $request->nik)->firstOrFail();

        $data = $request->all();
        $data['nama'] = $user->name;

        TransaksiPiutang::create($data);

        return redirect()->route('admin.piutang.index')->with('success', 'Data piutang berhasil ditambahkan.');
    }

    public function edit(TransaksiPiutang $piutang)
    {
        $anggota = User::where('role', 'member')->orderBy('name')->get();
        return view('admin.piutang.edit', compact('piutang', 'anggota'));
    }

    public function update(Request $request, TransaksiPiutang $piutang)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'jumlah_pinjaman_baru' => 'nullable|numeric|min:0',
            'jangka_waktu_bulan' => 'nullable|integer|min:0',
            'bayar_pokok' => 'nullable|numeric|min:0',
            'bayar_bunga' => 'nullable|numeric|min:0',
            'id_pinjaman' => 'nullable|integer|exists:transaksi_piutangs,id',
        ]);

        $user = User::where('nik', $request->nik)->firstOrFail();

        $data = $request->all();
        $data['nama'] = $user->name;

        $piutang->update($data);

        return redirect()->route('admin.piutang.index')->with('success', 'Data piutang berhasil diperbarui.');
    }

    public function destroy(TransaksiPiutang $piutang)
    {
        $piutang->delete();
        return redirect()->route('admin.piutang.index')->with('success', 'Data piutang berhasil dihapus.');
    }
}

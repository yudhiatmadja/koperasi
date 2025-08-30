<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiPiutang;

class TransaksiPiutangController extends Controller
{
    /**
     * Menyimpan transaksi angsuran baru untuk sebuah pinjaman.
     */
    public function storeAngsuran(Request $request, Pinjaman $pinjaman)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'bayar_pokok' => 'required|numeric|min:0',
            'bayar_bunga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Pastikan angsuran tidak melebihi sisa pinjaman
        if ($validated['bayar_pokok'] > $pinjaman->sisa_pokok_pinjaman) {
            return back()->withErrors(['bayar_pokok' => 'Pembayaran pokok melebihi sisa pinjaman.']);
        }

        DB::transaction(function () use ($validated, $pinjaman) {
            // 1. Catat transaksi angsuran di tabel 'transaksi_piutangs'
            $pinjaman->transaksi()->create([
                'nik' => $pinjaman->user_nik,
                'nama' => $pinjaman->user->name,
                'tanggal_transaksi' => $validated['tanggal_transaksi'],
                'keterangan' => $validated['keterangan'] ?? 'Pembayaran Angsuran',
                'bayar_pokok' => $validated['bayar_pokok'],
                'bayar_bunga' => $validated['bayar_bunga'],
            ]);

            // 2. Update sisa pokok dan status di tabel 'pinjamans'
            $pinjaman->sisa_pokok_pinjaman -= $validated['bayar_pokok'];
            if ($pinjaman->sisa_pokok_pinjaman <= 0) {
                $pinjaman->status = 'LUNAS';
            }
            $pinjaman->save();
        });

        return back()->with('success', 'Pembayaran angsuran berhasil dicatat.');
    }

     public function edit(TransaksiPiutang $transaksi)
    {
        return view('admin.transaksi_piutang.edit', compact('transaksi'));
    }

    /**
     * Mengupdate transaksi piutang dan menghitung ulang sisa pinjaman.
     */
    public function update(Request $request, TransaksiPiutang $transaksi)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'bayar_pokok' => 'required|numeric|min:0',
            'bayar_bunga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pinjaman = $transaksi->pinjaman;

        DB::transaction(function () use ($validated, $transaksi, $pinjaman) {
            // Simpan nilai bayar pokok yang lama sebelum diupdate
            $bayarPokokLama = $transaksi->bayar_pokok;

            // 1. Update record transaksi itu sendiri
            $transaksi->update($validated);

            // 2. Hitung ulang sisa pokok pinjaman di tabel induk 'pinjamans'
            // Rumus: Kembalikan dulu nilai lama, lalu kurangi dengan nilai baru
            $pinjaman->sisa_pokok_pinjaman = ($pinjaman->sisa_pokok_pinjaman + $bayarPokokLama) - $validated['bayar_pokok'];

            // 3. Update status pinjaman
            $pinjaman->status = ($pinjaman->sisa_pokok_pinjaman <= 0) ? 'LUNAS' : 'BELUM LUNAS';
            $pinjaman->save();
        });

        return redirect()->route('admin.pinjaman.show', $pinjaman->id)->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi piutang dan menghitung ulang sisa pinjaman.
     */
    public function destroy(TransaksiPiutang $transaksi)
    {
        $pinjaman = $transaksi->pinjaman;

        // Peringatan: Jangan hapus transaksi pencairan! (Bisa ditambahkan validasi)
        if ($transaksi->jumlah_pinjaman_baru > 0) {
            return back()->withErrors(['error' => 'Transaksi pencairan tidak dapat dihapus. Silakan hapus seluruh data pinjaman.']);
        }

        DB::transaction(function () use ($transaksi, $pinjaman) {
            // 1. Hitung ulang sisa pokok: Tambahkan kembali jumlah yang dihapus
            $pinjaman->sisa_pokok_pinjaman += $transaksi->bayar_pokok;
            $pinjaman->status = 'BELUM LUNAS'; // Pastikan status kembali belum lunas
            $pinjaman->save();

            // 2. Hapus record transaksi
            $transaksi->delete();
        });

        return redirect()->route('admin.pinjaman.show', $pinjaman->id)->with('success', 'Transaksi berhasil dihapus.');
    }
}

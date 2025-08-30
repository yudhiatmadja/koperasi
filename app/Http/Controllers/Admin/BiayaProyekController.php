<?php

namespace App\Http\Controllers\Admin;

use App\Models\Proyek;
use App\Models\BiayaProyek;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BiayaProyekController extends Controller
{
    public function store(Request $request, Proyek $proyek)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $proyek->biayas()->create($validated);

        return back()->with('success', 'Data biaya berhasil ditambahkan.');
    }

    public function destroy(BiayaProyek $biaya)
{
    $biaya->delete();
    return back()->with('success', 'Data biaya berhasil dihapus.');
}

public function edit(BiayaProyek $biaya)
{
    return view('admin.biaya.edit', compact('biaya'));
}

public function update(Request $request, BiayaProyek $biaya)
{
    $validated = $request->validate([
        'tanggal_transaksi' => 'required|date',
        'deskripsi' => 'required|string|max:255',
        'jumlah' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string',
    ]);

    $biaya->update($validated);

    return redirect()->route('admin.proyek.show', $biaya->proyek_id)->with('success', 'Data biaya berhasil diperbarui.');
}
}

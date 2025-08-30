<?php

namespace App\Http\Controllers\Admin;

use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Models\TagihanProyek;
use App\Http\Controllers\Controller;

class TagihanProyekController extends Controller
{
    public function store(Request $request, Proyek $proyek)
    {
        $validated = $request->validate([
            'tanggal_tagihan' => 'required|date',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'tanggal_bayar' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $proyek->tagihans()->create($validated);

        return back()->with('success', 'Data tagihan berhasil ditambahkan.');
    }

    public function destroy(TagihanProyek $tagihan)
{
    $tagihan->delete();
    return back()->with('success', 'Data tagihan berhasil dihapus.');
}

public function edit(TagihanProyek $tagihan)
{
    // Mengirim data tagihan ke view form edit
    return view('admin.tagihan.edit', compact('tagihan'));
}

public function update(Request $request, TagihanProyek $tagihan)
{
    $validated = $request->validate([
        'tanggal_tagihan' => 'required|date',
        'jumlah_tagihan' => 'required|numeric|min:0',
        'tanggal_bayar' => 'nullable|date',
        'keterangan' => 'nullable|string',
    ]);

    $tagihan->update($validated);

    // Arahkan kembali ke halaman detail proyek setelah update
    return redirect()->route('admin.proyek.show', $tagihan->proyek_id)->with('success', 'Data tagihan berhasil diperbarui.');
}
}

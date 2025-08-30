<?php

namespace App\Http\Controllers\Admin;

use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Models\TahapanProyek;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class TahapanProyekController extends Controller
{
    public function update(Request $request, TahapanProyek $tahapan)
{
    $validatedData = $request->validate([
        'keberadaan' => ['nullable', Rule::in(['ADA', 'TIDAK_ADA'])],
        'status_text' => 'nullable|string|max:255',
        'keterangan' => 'nullable|string',
    ]);


    $tahapan->update($validatedData);

    return back()->with('success', 'Tahapan Proyek berhasil diperbarui.');
}

    public function store(Request $request, Proyek $proyek)
{
    $validated = $request->validate([
        'urutan' => 'nullable|integer',
        'uraian' => 'required|string|max:255',
    ]);

    $proyek->tahapans()->create($validated);

    return back()->with('success', 'Tahapan baru berhasil ditambahkan.');
}

public function destroy(TahapanProyek $tahapan)
{
    $tahapan->delete();
    return back()->with('success', 'Tahapan proyek berhasil dihapus.');
}
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProyekController extends Controller
{
    /**
     * Menampilkan daftar semua proyek.
     * Halaman "Manajemen Proyek".
     */
    public function index()
    {
        // Mengambil semua data proyek, diurutkan dari yang terbaru, dan dibagi per halaman (10 item per halaman)
        $proyeks = Proyek::latest()->paginate(10);

        // Mengirim data $proyeks ke view 'index'
        return view('admin.proyek.index', compact('proyeks'));
    }

    /**
     * Menampilkan formulir untuk membuat proyek baru.
     */
    public function create()
    {
        return view('admin.proyek.create');
    }

    /**
     * Menyimpan data proyek baru dari form ke database.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'nomor_proyek' => 'nullable|string|max:50|unique:proyeks',
            'tanggal_proyek' => 'required|date',
            'nilai_proyek' => 'required|numeric|min:0',
            'cogs' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Jika validasi berhasil, buat record baru di tabel 'proyeks'
        Proyek::create($validatedData);

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.proyek.index')->with('success', 'Proyek baru berhasil dibuat.');
    }

    /**
     * Menampilkan detail spesifik dari satu proyek (Kartu Proyek).
     */
    public function show(Proyek $proyek)
    {
        // Eager load semua relasi (tahapan, tagihan, biaya) untuk efisiensi query
        $proyek->load(['tahapans', 'tagihans', 'biayas']);

        // Melakukan kalkulasi keuangan
        $totalTagihan = $proyek->tagihans->sum('jumlah_tagihan');
        $totalBiaya = $proyek->biayas->sum('jumlah');
        $margin = $proyek->nilai_proyek - $proyek->cogs;

        // Hitung persentase Margin
        $marginPercentage = ($proyek->nilai_proyek > 0) ? ($margin / $proyek->nilai_proyek) * 100 : 0;

        // Hitung Sisa dari COGS
        $sisaCogs = $proyek->cogs - $totalBiaya;

        // Cek apakah biaya melebihi COGS
        $biayaMelebihiCogs = $totalBiaya > $proyek->cogs;

        // Mengirim semua data yang dibutuhkan ke view 'show'
        return view('admin.proyek.show', compact(
        'proyek',
        'totalTagihan',
        'totalBiaya',
        'margin',
        'marginPercentage',
        'sisaCogs',
        'biayaMelebihiCogs'
    ));
    }

    /**
     * Menampilkan formulir untuk mengedit data proyek yang sudah ada.
     */
    public function edit(Proyek $proyek)
    {
        // Mengirim data proyek yang akan diedit ke view 'edit'
        return view('admin.proyek.edit', compact('proyek'));
    }

    /**
     * Mengupdate data proyek yang ada di database.
     */
    public function update(Request $request, Proyek $proyek)
    {
        // Validasi data yang masuk dari form edit
        $validatedData = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'nomor_proyek' => ['nullable', 'string', 'max:50', Rule::unique('proyeks')->ignore($proyek->id)],
            'tanggal_proyek' => 'required|date',
            'nilai_proyek' => 'required|numeric|min:0',
            'cogs' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Jika validasi berhasil, update record proyek yang ada
        $proyek->update($validatedData);

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.proyek.index')->with('success', 'Data proyek berhasil diperbarui.');
    }

    /**
     * Menghapus data proyek dari database.
     */
    public function destroy(Proyek $proyek)
    {
        // Hapus record proyek dari database
        $proyek->delete();

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.proyek.index')->with('success', 'Proyek berhasil dihapus.');
    }
}

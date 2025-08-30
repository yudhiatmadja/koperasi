<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimpananBulanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SimpananController extends Controller
{
    public function index()
    {
        $simpanan = SimpananBulanan::latest()->paginate(15);
        return view('admin.simpanan.index', compact('simpanan'));
    }

    public function create()
    {
        $anggota = User::where('role', 'member')->orderBy('name')->get();
        return view('admin.simpanan.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'periode' => [
            'required',
            'string',
            'size:7',
            Rule::unique('simpanan_bulanans')->where(function ($query) use ($request) {
                return $query->where('nik', $request->nik);
            }),
        ],
            'saldo_awal' => 'nullable|numeric|min:0',
            'total_pokok' => 'nullable|numeric|min:0',
            'total_wajib' => 'nullable|numeric|min:0',
            'total_sukarela' => 'nullable|numeric|min:0',
            'total_penarikan' => 'nullable|numeric|min:0',
            'total_tunai' => 'nullable|numeric|min:0',
            'total_bank' => 'nullable|numeric|min:0',

        ],
    [
        'periode.unique' => 'Periode untuk anggota ini sudah ada. Silakan edit data yang sudah ada.',
    ]);

        $user = User::where('nik', $request->nik)->firstOrFail();

        $data = $request->all();
        $data['nama'] = $user->name;
        $data['saldo_akhir'] = ($request->saldo_awal ?? 0)
                                + ($request->total_pokok ?? 0)
                                + ($request->total_wajib ?? 0)
                                + ($request->total_sukarela ?? 0)
                                - ($request->total_penarikan ?? 0);

        SimpananBulanan::create($request->all() + ['nama' => $user->name]);

        return redirect()->route('admin.simpanan.index')->with('success', 'Data simpanan berhasil ditambahkan.');
    }

    public function edit(SimpananBulanan $simpanan)
    {
        $anggota = User::where('role', 'member')->orderBy('name')->get();
        return view('admin.simpanan.edit', compact('simpanan', 'anggota'));
    }

    public function update(Request $request, SimpananBulanan $simpanan)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'periode' => [
            'required',
            'string',
            'size:7',
            Rule::unique('simpanan_bulanans')->where(function ($query) use ($request) {
                return $query->where('nik', $request->nik);
            })->ignore($simpanan->id), // <-- Tambahan: Abaikan ID saat ini
        ],
            'saldo_awal' => 'nullable|numeric|min:0',
            'total_pokok' => 'nullable|numeric|min:0',
            'total_wajib' => 'nullable|numeric|min:0',
            'total_sukarela' => 'nullable|numeric|min:0',
            'total_penarikan' => 'nullable|numeric|min:0',
            'total_tunai' => 'nullable|numeric|min:0',
            'total_bank' => 'nullable|numeric|min:0',
        ],
    [
        'periode.unique' => 'Periode untuk anggota ini sudah ada. Silakan edit data yang sudah ada.',
    ]);

        $user = User::where('nik', $request->nik)->firstOrFail();

        $data = $request->all();
        $data['nama'] = $user->name;
        $data['saldo_akhir'] = ($request->saldo_awal ?? 0)
                                + ($request->total_pokok ?? 0)
                                + ($request->total_wajib ?? 0)
                                + ($request->total_sukarela ?? 0)
                                - ($request->total_penarikan ?? 0);

        $simpanan->update($request->all() + ['nama' => $user->name]);

        return redirect()->route('admin.simpanan.index')->with('success', 'Data simpanan berhasil diperbarui.');
    }

    public function destroy(SimpananBulanan $simpanan)
    {
        $simpanan->delete();
        return redirect()->route('admin.simpanan.index')->with('success', 'Data simpanan berhasil dihapus.');
    }
}

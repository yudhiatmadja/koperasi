<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'member')->latest()->paginate(15);
        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // Otomatis set sebagai member
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota baru berhasil ditambahkan.');
    }

    public function edit(User $anggotum) // Laravel akan otomatis resolve $anggota menjadi $anggotum
    {
        return view('admin.anggota.edit', ['anggota' => $anggotum]);
    }

    public function update(Request $request, User $anggotum)
    {
        $request->validate([
            'nik' => ['required', 'string', 'max:20', 'unique:'.User::class.',nik,'.$anggotum->id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$anggotum->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $anggotum->update($data);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $anggotum)
    {
        $anggotum->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}

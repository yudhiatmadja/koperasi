<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl ...">{{ __('Buat Pinjaman Baru') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto ...">
            <div class="bg-white dark:bg-gray-800 overflow-hidden ...">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.pinjaman.store') }}" x-data="{ peminjamType: 'anggota' }">
    @csrf

    <!-- Pilihan Jenis Peminjam -->
    <div class="mb-4">
        <x-input-label :value="__('Jenis Peminjam')" />
        <div class="mt-2 space-x-4">
            <label><input type="radio" x-model="peminjamType" value="anggota"> Anggota</label>
            <label><input type="radio" x-model="peminjamType" value="non_anggota"> Non-Anggota</label>
        </div>
    </div>

    <!-- Dropdown Anggota (Muncul jika 'anggota' dipilih) -->
    <div class="mb-4" x-show="peminjamType === 'anggota'" x-transition>
        <x-input-label for="user_nik" :value="__('Anggota')" />
        <select name="user_nik" id="user_nik" class="block mt-1 w-full ...">
            <option value="">-- Pilih Anggota --</option>
            @foreach ($anggota as $user)
                <option value="{{ $user->nik }}">{{ $user->name }} ({{ $user->nik }})</option>
            @endforeach
        </select>
    </div>

    <!-- Input Nama Non-Anggota (Muncul jika 'non_anggota' dipilih) -->
    <div class="mb-4" x-show="peminjamType === 'non_anggota'" x-transition>
        <x-input-label for="nama_peminjam_non_anggota" :value="__('Nama Peminjam Non-Anggota')" />
        <x-text-input id="nama_peminjam_non_anggota" type="text" name="nama_peminjam_non_anggota" class="block mt-1 w-full"/>
    </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_pinjaman" :value="__('Tanggal Pinjaman')" />
                                <x-text-input id="tanggal_pinjaman" type="date" name="tanggal_pinjaman" class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <x-input-label for="jumlah_pinjaman" :value="__('Jumlah Pinjaman (Rp)')" />
                                <x-text-input id="jumlah_pinjaman" type="number" name="jumlah_pinjaman" class="block mt-1 w-full" required min="1000"/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="jangka_waktu_bulan" :value="__('Jangka Waktu (Bulan)')" />
                            <x-text-input id="jangka_waktu_bulan" type="number" name="jangka_waktu_bulan" class="block mt-1 w-full" required min="1"/>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.pinjaman.index') }}" class="mr-4">Batal</a>
                            <x-primary-button>Simpan Pinjaman</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

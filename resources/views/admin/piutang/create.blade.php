<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Transaksi Piutang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.piutang.store') }}">
                        @csrf

                        <!-- Anggota (Sama seperti Simpanan) -->
                        <div class="mb-4">
                            <x-input-label for="nik" :value="__('Anggota')" />
                            <select name="nik" id="nik" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($anggota as $user)
                                    <option value="{{ $user->nik }}" {{ old('nik') == $user->nik ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                            <x-text-input id="tanggal_transaksi" class="block mt-1 w-full" type="date" name="tanggal_transaksi" :value="old('tanggal_transaksi')" required />
                            <x-input-error :messages="$errors->get('tanggal_transaksi')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="old('keterangan')" placeholder="Contoh: Pinjaman baru, Angsuran ke-3" />
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <hr class="my-6">
                        <p class="text-sm text-gray-600 mb-4">Isi bagian di bawah ini sesuai jenis transaksi (Pinjaman Baru atau Pembayaran Angsuran).</p>

                        <!-- PINJAMAN BARU -->
                        <h3 class="font-semibold mb-2">Untuk Pinjaman Baru</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="jumlah_pinjaman_baru" :value="__('Jumlah Pinjaman Baru (Debit)')" />
                                <x-text-input id="jumlah_pinjaman_baru" class="block mt-1 w-full" type="number" name="jumlah_pinjaman_baru" :value="old('jumlah_pinjaman_baru', 0)" min="0" />
                            </div>
                            <div>
                                <x-input-label for="jangka_waktu_bulan" :value="__('Jangka Waktu (Bulan)')" />
                                <x-text-input id="jangka_waktu_bulan" class="block mt-1 w-full" type="number" name="jangka_waktu_bulan" :value="old('jangka_waktu_bulan', 0)" min="0" />
                            </div>
                        </div>

                        <!-- PEMBAYARAN ANGSURAN -->
                        <h3 class="font-semibold mb-2">Untuk Pembayaran Angsuran</h3>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="bayar_pokok" :value="__('Bayar Pokok (Kredit)')" />
                                <x-text-input id="bayar_pokok" class="block mt-1 w-full" type="number" name="bayar_pokok" :value="old('bayar_pokok', 0)" min="0" />
                            </div>
                            <div>
                                <x-input-label for="bayar_bunga" :value="__('Bayar Bunga (Kredit)')" />
                                <x-text-input id="bayar_bunga" class="block mt-1 w-full" type="number" name="bayar_bunga" :value="old('bayar_bunga', 0)" min="0" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.piutang.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-100 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

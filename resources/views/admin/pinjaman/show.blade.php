<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold ...">Detail Pinjaman: {{ $pinjaman->user->name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Detail Pinjaman -->
            <div class="bg-white dark:bg-gray-800 ... p-6">
                <h3 class="text-lg ...">Informasi Pinjaman</h3>
                <p><strong>Jumlah Pinjaman:</strong> Rp {{ number_format($pinjaman->jumlah_pinjaman) }}</p>
                <p><strong>Sisa Pokok:</strong> Rp {{ number_format($pinjaman->sisa_pokok_pinjaman) }}</p>
                <p><strong>Status:</strong> {{ $pinjaman->status }}</p>
            </div>

            <!-- BAGIAN RIWAYAT TRANSAKSI (PIUTANG) - VERSI LENGKAP -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Transaksi (Piutang)</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Keterangan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Debit (+)
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kredit (-)
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                @forelse ($pinjaman->transaksi->sortBy('tanggal_transaksi') as $transaksi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $transaksi->keterangan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                            {{ $transaksi->jumlah_pinjaman_baru > 0 ? 'Rp '.number_format($transaksi->jumlah_pinjaman_baru) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                            {{ $transaksi->bayar_pokok > 0 ? 'Rp '.number_format($transaksi->bayar_pokok) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{-- Tampilkan aksi HANYA untuk transaksi ANGSURAN (bukan pencairan) --}}
                            @if ($transaksi->jumlah_pinjaman_baru == 0)
                                <a href="{{ route('admin.transaksi-piutang.edit', $transaksi) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.transaksi-piutang.destroy', $transaksi) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Sisa pinjaman akan dihitung ulang.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            @else
                                {{-- Tampilkan teks biasa untuk transaksi PENCAIRAN --}}
                                <span class="text-gray-400 italic">Pencairan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

        <!-- Form Tambah Angsuran (Jika Belum Lunas) -->
@if ($pinjaman->status == 'BELUM LUNAS')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 dark:text-gray-100 mb-4">Tambah Pembayaran Angsuran</h3>

    <!-- Tampilkan error validasi jika ada -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pinjaman.angsuran.store', $pinjaman) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tanggal Transaksi -->
            <div>
                <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                <x-text-input id="tanggal_transaksi" class="block mt-1 w-full" type="date" name="tanggal_transaksi" :value="old('tanggal_transaksi', now()->format('Y-m-d'))" required />
            </div>

            <!-- Pembayaran Pokok -->
            <div>
                <x-input-label for="bayar_pokok" :value="__('Pembayaran Pokok (Rp)')" />
                <x-text-input id="bayar_pokok" class="block mt-1 w-full" type="number" name="bayar_pokok" :value="old('bayar_pokok', 0)" required min="0" />
            </div>

            <!-- Pembayaran Bunga -->
            <div>
                <x-input-label for="bayar_bunga" :value="__('Pembayaran Bunga (Rp)')" />
                <x-text-input id="bayar_bunga" class="block mt-1 w-full" type="number" name="bayar_bunga" :value="old('bayar_bunga', 0)" required min="0" />
            </div>

            <!-- Keterangan -->
            <div class="lg:col-span-4">
                 <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="old('keterangan')" placeholder="Contoh: Angsuran ke-1" />
            </div>
        </div>

        <div class="flex items-center mt-6">
            <x-primary-button>
                {{ __('Simpan Angsuran') }}
            </x-primary-button>
        </div>
    </form>
</div>
@endif
        </div>
    </div>
</x-app-layout>

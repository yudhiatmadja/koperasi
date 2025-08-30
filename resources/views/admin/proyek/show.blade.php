<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Kartu Proyek: {{ $proyek->nama_pekerjaan }}
        </h2>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- BAGIAN DETAIL PROYEK & KALKULASI -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Detail Proyek -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            Detail Proyek
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-400">Nomor Proyek:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $proyek->nomor_proyek ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Proyek:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($proyek->tanggal_proyek)->format('d F Y') }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="font-medium text-gray-600 dark:text-gray-400">Periode:</span>
                                <span class="text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span class="font-medium text-gray-600 dark:text-gray-400">Nilai Proyek:</span>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    Rp {{ number_format($proyek->nilai_proyek, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kalkulasi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            Ringkasan Keuangan
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">COGS</span>
                                <span class="font-mono text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($proyek->cogs, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Margin</span>
                                <div class="text-right">
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ number_format($marginPercentage, 1, ',') }}%
                                    </div>
                                    <div class="font-mono font-bold text-gray-900 dark:text-gray-100">
                                        Rp {{ number_format($margin, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-3">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">TOTAL</span>
                                <span class="font-mono text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($proyek->nilai_proyek, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">TOTAL BIAYA</span>
                                <span class="font-mono text-red-600 dark:text-red-400">
                                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-3">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">SISA</span>
                                <span class="font-mono font-bold {{ $sisaCogs < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    Rp {{ number_format($sisaCogs, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN TAHAPAN / CHECKLIST -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tahapan Proyek</h3>

                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-md text-sm border border-green-300 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <div class="min-w-full">
                            <!-- Desktop Table -->
                            <table class="hidden lg:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-16">
                                            No
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Uraian
                                        </th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">
                                            Ada
                                        </th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">
                                            Tdk Ada
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">
                                            Status
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">
                                            Keterangan
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($proyek->tahapans as $tahapan)
                                        <tr class="">
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                                {{ $tahapan->urutan ?? $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                <div class="max-w-xs break-words">{{ $tahapan->uraian }}</div>
                                            </td>

                                            <form action="{{ route('admin.tahapan-proyek.update', $tahapan) }}" method="POST"
                                                id="form-update-{{ $tahapan->id }}" class="contents">
                                                @csrf
                                                @method('PUT')

                                                <td class="px-3 py-4 text-center">
                                                    <input type="radio" name="keberadaan" value="ADA"
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 dark:text-indigo-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                        {{ $tahapan->keberadaan == 'ADA' ? 'checked' : '' }}>
                                                </td>
                                                <td class="px-3 py-4 text-center">
                                                    <input type="radio" name="keberadaan" value="TIDAK_ADA"
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 dark:text-indigo-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                        {{ $tahapan->keberadaan == 'TIDAK_ADA' ? 'checked' : '' }}>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <x-text-input name="status_text" class="w-full text-xs"
                                                        :value="$tahapan->status_text" />
                                                </td>
                                                <td class="px-4 py-4">
                                                    <x-text-input name="keterangan" class="w-full text-xs"
                                                        :value="$tahapan->keterangan" />
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <div class="flex flex-col space-y-2">
                                                        <x-primary-button type="submit" class="text-xs px-2 py-1">
                                                            Update
                                                        </x-primary-button>
                                                    </div>
                                                </td>
                                            </form>
                                            <td class="px-4 py-4 text-center">
                                                <form action="{{ route('admin.tahapan.destroy', $tahapan) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus tahapan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-xs font-medium px-2 py-1 rounded border border-red-300 dark:border-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    <p>Belum ada tahapan yang ditambahkan untuk proyek ini.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Mobile Cards -->
                            <div class="lg:hidden space-y-4">
                                @forelse ($proyek->tahapans as $tahapan)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium rounded-full">
                                                    {{ $tahapan->urutan ?? $loop->iteration }}
                                                </span>
                                                <span class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                                    {{ $tahapan->uraian }}
                                                </span>
                                            </div>
                                            <form action="{{ route('admin.tahapan.destroy', $tahapan) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus tahapan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <form action="{{ route('admin.tahapan-proyek.update', $tahapan) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PUT')

                                            <div class="flex items-center justify-center space-x-6">
                                                <label class="flex items-center">
                                                    <input type="radio" name="keberadaan" value="ADA"
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 dark:text-indigo-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700 mr-2"
                                                        {{ $tahapan->keberadaan == 'ADA' ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Ada</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="keberadaan" value="TIDAK_ADA"
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 dark:text-indigo-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700 mr-2"
                                                        {{ $tahapan->keberadaan == 'TIDAK_ADA' ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Tidak Ada</span>
                                                </label>
                                            </div>

                                            <div class="grid grid-cols-1 gap-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Status</label>
                                                    <x-text-input name="status_text" class="w-full text-sm" :value="$tahapan->status_text" />
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Keterangan</label>
                                                    <x-text-input name="keterangan" class="w-full text-sm" :value="$tahapan->keterangan" />
                                                </div>
                                            </div>

                                            <div class="flex justify-end">
                                                <x-primary-button type="submit" class="text-sm px-4 py-2">
                                                    Update
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">Belum ada tahapan yang ditambahkan untuk proyek ini.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Form Tambah Tahapan Baru -->
                    <div class="border-t border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Tambah Tahapan Baru</h4>
                        <form action="{{ route('admin.proyek.tahapan.store', $proyek) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-input-label for="urutan" :value="__('No. Urut')" class="text-sm" />
                                    <x-text-input id="urutan" class="block mt-1 w-full text-sm" type="number" name="urutan"
                                        :value="old('urutan')" placeholder="Auto" />
                                </div>
                                <div class="md:col-span-3">
                                    <x-input-label for="uraian" :value="__('Uraian Tahapan')" class="text-sm" />
                                    <x-text-input id="uraian" class="block mt-1 w-full text-sm" type="text" name="uraian"
                                        :value="old('uraian')" required placeholder="Masukkan uraian tahapan..." />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button class="text-sm">Simpan Tahapan</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- BAGIAN TAGIHAN -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Tagihan</h3>

                    <div class="overflow-x-auto">
                        <!-- Desktop Table -->
                        <table class="hidden md:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Tagihan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Bayar
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($proyek->tagihans as $tagihan)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            @if($tagihan->tanggal_bayar)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                    {{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d M Y') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                                    Belum Dibayar
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.tagihan.edit', $tagihan) }}"
                                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus tagihan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p>Belum ada riwayat tagihan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Mobile Cards untuk Tagihan -->
                        <div class="md:hidden space-y-3">
                            @forelse ($proyek->tagihans as $tagihan)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                Tagihan: {{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 ml-2">
                                            <a href="{{ route('admin.tagihan.edit', $tagihan) }}"
                                                class="text-indigo-600 dark:text-indigo-400 text-sm">Edit</a>
                                            <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus tagihan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 text-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="text-xs">
                                        @if($tagihan->tanggal_bayar)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                Dibayar: {{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                                Belum Dibayar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat tagihan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Form Tambah Tagihan Baru -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Tambah Tagihan Baru</h4>
                    <form action="{{ route('admin.proyek.tagihan.store', $proyek) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_tagihan" :value="__('Tanggal Tagihan')" class="text-sm" />
                                <x-text-input id="tanggal_tagihan" class="block mt-1 w-full text-sm" type="date"
                                    name="tanggal_tagihan" required />
                            </div>
                            <div>
                                <x-input-label for="jumlah_tagihan" :value="__('Jumlah Tagihan (Rp)')" class="text-sm" />
                                <x-text-input id="jumlah_tagihan" class="block mt-1 w-full text-sm" type="number"
                                    name="jumlah_tagihan" required min="0" placeholder="0" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_bayar" :value="__('Tanggal Bayar (Opsional)')" class="text-sm" />
                                <x-text-input id="tanggal_bayar" class="block mt-1 w-full text-sm" type="date"
                                    name="tanggal_bayar" />
                            </div>
                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" class="text-sm" />
                                <x-text-input id="keterangan" class="block mt-1 w-full text-sm" type="text"
                                    name="keterangan" placeholder="Keterangan tambahan..." />
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button class="text-sm">Simpan Tagihan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- BAGIAN BIAYA -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    @if ($biayaMelebihiCogs)
                        <div class="p-4 mb-4 text-sm text-red-800 dark:text-red-300 rounded-lg bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700"
                            role="alert">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-bold">Peringatan!</span>
                            </div>
                            <p class="mt-1">Total biaya yang diinput (Rp {{ number_format($totalBiaya) }}) telah melebihi batas COGS (Rp {{ number_format($proyek->cogs) }}).</p>
                        </div>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Biaya</h3>

                    <div class="overflow-x-auto">
                        <!-- Desktop Table -->
                        <table class="hidden md:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Transaksi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($proyek->biayas as $biaya)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($biaya->tanggal_transaksi)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="max-w-xs break-words">{{ $biaya->deskripsi }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($biaya->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.biaya.edit', $biaya) }}"
                                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.biaya.destroy', $biaya) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus biaya ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                <p>Belum ada riwayat biaya.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Mobile Cards untuk Biaya -->
                        <div class="md:hidden space-y-3">
                            @forelse ($proyek->biayas as $biaya)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($biaya->jumlah, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                                {{ \Carbon\Carbon::parse($biaya->tanggal_transaksi)->format('d M Y') }}
                                            </div>
                                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                                {{ $biaya->deskripsi }}
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 ml-2">
                                            <a href="{{ route('admin.biaya.edit', $biaya) }}"
                                                class="text-indigo-600 dark:text-indigo-400 text-sm">Edit</a>
                                            <form action="{{ route('admin.biaya.destroy', $biaya) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus biaya ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 text-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat biaya.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Form Tambah Biaya Baru -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Tambah Biaya Baru</h4>
                    <form action="{{ route('admin.proyek.biaya.store', $proyek) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" class="text-sm" />
                                <x-text-input id="tanggal_transaksi" class="block mt-1 w-full text-sm" type="date"
                                    name="tanggal_transaksi" required />
                            </div>
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah Biaya (Rp)')" class="text-sm" />
                                <x-text-input id="jumlah" class="block mt-1 w-full text-sm" type="number" name="jumlah"
                                    required min="0" placeholder="0" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="deskripsi" :value="__('Deskripsi')" class="text-sm" />
                                <x-text-input id="deskripsi" class="block mt-1 w-full text-sm" type="text" name="deskripsi"
                                    required placeholder="Deskripsi biaya..." />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="keterangan_biaya" :value="__('Keterangan (Opsional)')" class="text-sm" />
                                <x-text-input id="keterangan_biaya" class="block mt-1 w-full text-sm" type="text"
                                    name="keterangan" placeholder="Keterangan tambahan..." />
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button class="text-sm">Simpan Biaya</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Buku Piutang Anggota - Periode {{ $periode->format('F Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Form Filter Periode -->
                <form method="GET" action="{{ route('admin.laporan.piutang.index') }}" class="mb-6">
                    <x-input-label for="periode" :value="__('Pilih Periode Laporan')" />
                    <div class="flex items-center mt-2">
                        <x-text-input id="periode" type="month" name="periode" :value="$periode->format('Y-m')" class="mr-2"/>
                        <x-primary-button>Tampilkan</x-primary-button>
                    </div>
                </form>

                <!-- Tabel Laporan -->
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- THEAD SESUAI GAMBAR EXCEL -->
                        <thead class="bg-gray-50 dark:bg-gray-700">
                           <tr>
                                <th rowspan="2" class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">
                                    No
                                </th>
                                <th rowspan="2" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">
                                    Nama
                                </th>
                                <th rowspan="2" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">
                                    SALDO<br>{{ $periode->copy()->subMonth()->endOfMonth()->format('d F Y') }}
                                </th>
                                <th colspan="3" class="px-6 py-2 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">
                                    Mutasi (+)
                                </th>
                                <th colspan="3" class="px-6 py-2 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">
                                    Mutasi (-)
                                </th>
                                <th rowspan="2" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Saldo
                                </th>
                           </tr>
                           <tr class="border-t border-gray-200 dark:border-gray-600">
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">
                                    Tanggal
                                </th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">
                                    Jumlah
                                </th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">
                                    JW
                                </th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">
                                    Tanggal
                                </th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">
                                    Pokok
                                </th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">
                                    Bunga
                                </th>
                           </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($laporanData as $data)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-4 py-4 text-center text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['nama'] }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ number_format($data['saldo_awal']) }}
                                    </td>

                                    <!-- Mutasi Plus -->
                                    <td class="px-4 py-4 text-center text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['mutasi_plus'] ? \Carbon\Carbon::parse($data['mutasi_plus']->tanggal_transaksi)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-right text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['mutasi_plus'] ? number_format($data['mutasi_plus']->jumlah_pinjaman_baru) : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['mutasi_plus'] ? $data['mutasi_plus']->pinjaman->jangka_waktu_bulan : '-' }}
                                    </td>

                                    <!-- Mutasi Minus -->
                                    <td class="px-4 py-4 text-center text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['mutasi_minus'] ? \Carbon\Carbon::parse($data['mutasi_minus']->tanggal_transaksi)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-right text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['mutasi_minus'] ? number_format($data['mutasi_minus']->bayar_pokok) : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-right text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                        {{ $data['mutasi_minus'] ? number_format($data['mutasi_minus']->bayar_bunga) : '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ number_format($data['saldo_akhir']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <!-- TFOOT UNTUK TOTAL (Optional) -->
                        @if(count($laporanData) > 0)
                        <tfoot class="bg-gray-50 dark:bg-gray-700">
                            <tr class="border-t-2 border-gray-300 dark:border-gray-500">
                                <td colspan="2" class="px-6 py-4 text-center font-semibold text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                    TOTAL
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-sm text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-600">
                                    {{ number_format(array_sum(array_column($laporanData, 'saldo_awal'))) }}
                                </td>
                                <td colspan="3" class="px-4 py-4 border-r border-gray-200 dark:border-gray-600"></td>
                                <td colspan="3" class="px-4 py-4 border-r border-gray-200 dark:border-gray-600"></td>
                                <td class="px-6 py-4 text-right font-semibold text-sm text-gray-900 dark:text-gray-100">
                                    {{ number_format(array_sum(array_column($laporanData, 'saldo_akhir'))) }}
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                <!-- Export/Print Buttons (Optional) -->
                {{-- <div class="mt-6 flex justify-end space-x-2">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Export Excel
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Print
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>

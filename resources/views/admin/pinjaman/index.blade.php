<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pinjaman') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.pinjaman.create') }}" class="inline-flex items-center px-4 py-2
          bg-gray-800 dark:bg-indigo-600
          border border-transparent rounded-md font-semibold text-xs
          text-white uppercase tracking-widest
          hover:bg-gray-700 dark:hover:bg-indigo-500
          focus:bg-gray-700 dark:focus:bg-indigo-700
          active:bg-gray-900 dark:active:bg-indigo-800
          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
          transition ease-in-out duration-150">
                            {{ __('Buat Pinjaman Baru') }}
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 ...">{{ session('success') }}</div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y ...">
                            <thead>
                                <tr>
                                    <th>Anggota</th>
                                    <th>Tgl Pinjaman</th>
                                    <th>Jumlah Pinjaman</th>
                                    <th>Sisa Pokok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pinjamans as $pinjaman)
                                    <tr>
                                        <td>{{ $pinjaman->user->name ?? $pinjaman->user_nik }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($pinjaman->jumlah_pinjaman) }}</td>
                                        <td>Rp {{ number_format($pinjaman->sisa_pokok_pinjaman) }}</td>
                                        <td><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pinjaman->status == 'LUNAS' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $pinjaman->status }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.pinjaman.show', $pinjaman) }}" class="text-green-600 hover:text-green-900 font-bold">Detail</a>
                                            <a href="{{ route('admin.pinjaman.edit', $pinjaman) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <!-- Tombol Detail/Angsuran bisa ditambahkan di sini nanti -->
                                            <form action="{{ route('admin.pinjaman.destroy', $pinjaman) }}" method="POST" onsubmit="return confirm('Yakin hapus pinjaman ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 ...">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center p-4">Tidak ada data pinjaman.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

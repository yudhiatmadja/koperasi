<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Manajemen Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.anggota.create') }}" class="inline-flex items-center px-4 py-2
          bg-gray-800 dark:bg-indigo-600
          border border-transparent rounded-md font-semibold text-xs
          text-white uppercase tracking-widest
          hover:bg-gray-700 dark:hover:bg-indigo-500
          focus:bg-gray-700 dark:focus:bg-indigo-700
          active:bg-gray-900 dark:active:bg-indigo-800
          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
          transition ease-in-out duration-150">
                            {{ __('Tambah Anggota Baru') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-100 uppercase tracking-wider">NIK</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-100 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-100 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-100 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse ($anggota as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->nik }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.anggota.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.anggota.destroy', $user) }}" method="POST" class="inline ml-2" onsubmit="return confirm('PERINGATAN: Menghapus anggota akan menghapus semua data simpanan dan pinjaman terkait. Apakah Anda yakin?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-900 dark:text-gray-100">
                                            Tidak ada data anggota.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $anggota->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

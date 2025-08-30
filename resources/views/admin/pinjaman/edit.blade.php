<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pinjaman untuk: ') }} {{ $pinjaman->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.pinjaman.update', $pinjaman) }}">
                        @csrf
                        @method('PUT')

                        <!-- Anggota (Disabled) -->
                        <div class="mb-4">
                            <x-input-label for="user_nik" :value="__('Anggota (Tidak dapat diubah)')" />
                            <select name="user_nik" id="user_nik" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-100" disabled>
                                @foreach ($anggota as $user)
                                    <option value="{{ $user->nik }}" {{ $pinjaman->user_nik == $user->nik ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->nik }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Pinjaman -->
                            <div>
                                <x-input-label for="tanggal_pinjaman" :value="__('Tanggal Pinjaman')" />
                                <x-text-input id="tanggal_pinjaman" type="date" name="tanggal_pinjaman" :value="old('tanggal_pinjaman', $pinjaman->tanggal_pinjaman)" class="block mt-1 w-full" required />
                            </div>
                            <!-- Jumlah Pinjaman -->
                            <div>
                                <x-input-label for="jumlah_pinjaman" :value="__('Jumlah Pinjaman (Rp)')" />
                                <x-text-input id="jumlah_pinjaman" type="number" name="jumlah_pinjaman" :value="old('jumlah_pinjaman', $pinjaman->jumlah_pinjaman)" class="block mt-1 w-full" required min="1000"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                             <!-- Jangka Waktu -->
                            <div>
                                <x-input-label for="jangka_waktu_bulan" :value="__('Jangka Waktu (Bulan)')" />
                                <x-text-input id="jangka_waktu_bulan" type="number" name="jangka_waktu_bulan" :value="old('jangka_waktu_bulan', $pinjaman->jangka_waktu_bulan)" class="block mt-1 w-full" required min="1"/>
                            </div>
                            <!-- Sisa Pokok Pinjaman -->
                            <div>
                                <x-input-label for="sisa_pokok_pinjaman" :value="__('Sisa Pokok Pinjaman (Rp)')" />
                                <x-text-input id="sisa_pokok_pinjaman" type="number" name="sisa_pokok_pinjaman" :value="old('sisa_pokok_pinjaman', $pinjaman->sisa_pokok_pinjaman)" class="block mt-1 w-full" required min="0"/>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status Pinjaman')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="BELUM LUNAS" {{ $pinjaman->status == 'BELUM LUNAS' ? 'selected' : '' }}>BELUM LUNAS</option>
                                <option value="LUNAS" {{ $pinjaman->status == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.pinjaman.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Pinjaman') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

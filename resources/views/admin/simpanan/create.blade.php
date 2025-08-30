<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Simpanan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.simpanan.store') }}">
                        @csrf

                        <!-- Anggota -->
                        <div class="mb-4">
                            <x-input-label for="nik" :value="__('Anggota')" />
                            <select name="nik" id="nik"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600
       bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
       focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($anggota as $user)
                                    <option value="{{ $user->nik }}"
                                        {{ old('nik') == $user->nik ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <!-- Periode -->
                        <div class="mb-4">
                            <x-input-label for="periode" :value="__('Periode (Bulan & Tahun)')" />
                            <x-text-input id="periode" class="block mt-1 w-full" type="month" name="periode"
                                :value="old('periode')" required />
                            <x-input-error :messages="$errors->get('periode')" class="mt-2" />
                        </div>

                        <!-- Simpanan Pokok -->
                        <div class="mb-4">
                            <x-input-label for="total_pokok" :value="__('Simpanan Pokok')" />
                            <x-text-input id="total_pokok" class="block mt-1 w-full" type="number" name="total_pokok"
                                :value="old('total_pokok', 0)" min="0" />
                            <x-input-error :messages="$errors->get('total_pokok')" class="mt-2" />
                        </div>

                        <!-- Simpanan Wajib -->
                        <div class="mb-4">
                            <x-input-label for="total_wajib" :value="__('Simpanan Wajib')" />
                            <x-text-input id="total_wajib" class="block mt-1 w-full" type="number" name="total_wajib"
                                :value="old('total_wajib', 0)" min="0" />
                            <x-input-error :messages="$errors->get('total_wajib')" class="mt-2" />
                        </div>

                        <!-- Simpanan Sukarela -->
                        <div class="mb-4">
                            <x-input-label for="total_sukarela" :value="__('Simpanan Sukarela')" />
                            <x-text-input id="total_sukarela" class="block mt-1 w-full" type="number"
                                name="total_sukarela" :value="old('total_sukarela', 0)" min="0" />
                            <x-input-error :messages="$errors->get('total_sukarela')" class="mt-2" />
                        </div>

                        <!-- Penarikan -->
                        <div class="mb-4">
                            <x-input-label for="total_penarikan" :value="__('Total Penarikan')" />
                            <x-text-input id="total_penarikan" class="block mt-1 w-full" type="number"
                                name="total_penarikan" :value="old('total_penarikan', 0)" min="0" />
                            <x-input-error :messages="$errors->get('total_penarikan')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.simpanan.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 mr-4">
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

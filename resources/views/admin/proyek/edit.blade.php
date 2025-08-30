<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Proyek: ') }} {{ $proyek->nama_pekerjaan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.proyek.update', $proyek) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama Pekerjaan -->
                        <div class="mb-4">
                            <x-input-label for="nama_pekerjaan" :value="__('Nama Pekerjaan')" />
                            <x-text-input id="nama_pekerjaan" class="block mt-1 w-full" type="text" name="nama_pekerjaan" :value="old('nama_pekerjaan', $proyek->nama_pekerjaan)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_pekerjaan')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nomor Proyek -->
                            <div class="mb-4">
                                <x-input-label for="nomor_proyek" :value="__('Nomor Proyek (Opsional)')" />
                                <x-text-input id="nomor_proyek" class="block mt-1 w-full" type="text" name="nomor_proyek" :value="old('nomor_proyek', $proyek->nomor_proyek)" />
                                <x-input-error :messages="$errors->get('nomor_proyek')" class="mt-2" />
                            </div>

                             <!-- Tanggal Proyek -->
                             <div class="mb-4">
                                <x-input-label for="tanggal_proyek" :value="__('Tanggal Proyek')" />
                                <x-text-input id="tanggal_proyek" class="block mt-1 w-full" type="date" name="tanggal_proyek" :value="old('tanggal_proyek', $proyek->tanggal_proyek)" required />
                                <x-input-error :messages="$errors->get('tanggal_proyek')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Nilai Proyek -->
                        <div class="mb-4">
                            <x-input-label for="nilai_proyek" :value="__('Nilai Proyek (Rp)')" />
                            <x-text-input id="nilai_proyek" class="block mt-1 w-full" type="number" name="nilai_proyek" :value="old('nilai_proyek', $proyek->nilai_proyek)" required min="0" />
                            <x-input-error :messages="$errors->get('nilai_proyek')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Tanggal Mulai -->
                             <div class="mb-4">
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai" :value="old('tanggal_mulai', $proyek->tanggal_mulai)" required />
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                            </div>

                             <!-- Tanggal Selesai -->
                             <div class="mb-4">
                                <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                                <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="date" name="tanggal_selesai" :value="old('tanggal_selesai', $proyek->tanggal_selesai)" required />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.proyek.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Proyek') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

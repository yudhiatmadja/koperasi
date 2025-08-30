<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Tagihan untuk Proyek: {{ $tagihan->proyek->nama_pekerjaan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tagihan.update', $tagihan) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_tagihan" :value="__('Tanggal Tagihan')" />
                                <x-text-input id="tanggal_tagihan" class="block mt-1 w-full" type="date" name="tanggal_tagihan" :value="old('tanggal_tagihan', $tagihan->tanggal_tagihan)" required />
                            </div>
                            <div>
                                <x-input-label for="jumlah_tagihan" :value="__('Jumlah Tagihan (Rp)')" />
                                <x-text-input id="jumlah_tagihan" class="block mt-1 w-full" type="number" name="jumlah_tagihan" :value="old('jumlah_tagihan', $tagihan->jumlah_tagihan)" required min="0" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_bayar" :value="__('Tanggal Bayar (Opsional)')" />
                                <x-text-input id="tanggal_bayar" class="block mt-1 w-full" type="date" name="tanggal_bayar" :value="old('tanggal_bayar', $tagihan->tanggal_bayar)" />
                            </div>
                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                                <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="old('keterangan', $tagihan->keterangan)" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.proyek.show', $tagihan->proyek_id) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Tagihan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

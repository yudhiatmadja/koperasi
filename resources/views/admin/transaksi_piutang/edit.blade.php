<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold ...">
            Edit Transaksi Angsuran
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto ...">
            <div class="bg-white dark:bg-gray-800 overflow-hidden ... p-6">
                <form method="POST" action="{{ route('admin.transaksi-piutang.update', $transaksi) }}">
                    @csrf
                    @method('PUT')

                    <p class="mb-4">Mengedit transaksi untuk pinjaman an. <strong>{{ $transaksi->pinjaman->user->name ?? $transaksi->nama }}</strong></p>

                    <div>
                        <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                        <x-text-input id="tanggal_transaksi" type="date" name="tanggal_transaksi" :value="old('tanggal_transaksi', $transaksi->tanggal_transaksi)" class="block mt-1 w-full" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bayar_pokok" :value="__('Pembayaran Pokok (Rp)')" />
                        <x-text-input id="bayar_pokok" type="number" name="bayar_pokok" :value="old('bayar_pokok', $transaksi->bayar_pokok)" class="block mt-1 w-full" required min="0"/>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bayar_bunga" :value="__('Pembayaran Bunga (Rp)')" />
                        <x-text-input id="bayar_bunga" type="number" name="bayar_bunga" :value="old('bayar_bunga', $transaksi->bayar_bunga)" class="block mt-1 w-full" required min="0"/>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="keterangan" :value="__('Keterangan')" />
                        <x-text-input id="keterangan" type="text" name="keterangan" :value="old('keterangan', $transaksi->keterangan)" class="block mt-1 w-full"/>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.pinjaman.show', $transaksi->pinjaman_id) }}" class="text-sm ... mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button>
                            {{ __('Update Transaksi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PinjamanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_peminjam' => $this->nama_peminjam,
            'tanggal_pinjaman' => $this->tanggal_pinjaman,
            'jumlah_pinjaman' => (int) $this->jumlah_pinjaman,
            'sisa_pokok_pinjaman' => (int) $this->sisa_pokok_pinjaman,
            'jangka_waktu_bulan' => (int) $this->jangka_waktu_bulan,
            'status' => $this->status,
            'riwayat_transaksi' => TransaksiPiutangResource::collection($this->whenLoaded('transaksi')),
        ];
    }
}

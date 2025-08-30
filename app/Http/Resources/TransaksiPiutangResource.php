<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiPiutangResource extends JsonResource
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
            'nik' => $this->nik,
            'nama' => $this->nama,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'keterangan' => $this->keterangan,
            'jumlah_pinjaman_baru' => $this->jumlah_pinjaman_baru,
            'jangka_waktu_bulan' => $this->jangka_waktu_bulan,
            'bayar_pokok' => $this->bayar_pokok,
            'bayar_bunga' => $this->bayar_bunga,
            'id_pinjaman' => $this->id_pinjaman,
            'pinjaman_id' => $this->pinjaman_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagihanProyekResource extends JsonResource
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
            'proyek_id' => $this->proyek_id,
            'tanggal_tagihan' => $this->tanggal_tagihan,
            'jumlah_tagihan' => $this->jumlah_tagihan,
            'tanggal_bayar' => $this->tanggal_bayar,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

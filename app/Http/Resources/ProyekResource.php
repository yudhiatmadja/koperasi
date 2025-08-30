<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProyekResource extends JsonResource
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
            'nama_pekerjaan' => $this->nama_pekerjaan,
            'nomor_proyek' => $this->nomor_proyek,
            'nilai_proyek' => (int) $this->nilai_proyek,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'ringkasan' => [
                'total_tagihan' => (int) $this->tagihans->sum('jumlah_tagihan'),
                'total_biaya' => (int) $this->biayas->sum('jumlah'),
                'margin' => (int) ($this->nilai_proyek - $this->biayas->sum('jumlah')),
            ],
            // 'whenLoaded' memastikan relasi hanya dimuat jika sudah di-eager load di controller
            'tahapans' => TahapanProyekResource::collection($this->whenLoaded('tahapans')),
            'tagihans' => TagihanProyekResource::collection($this->whenLoaded('tagihans')),
            'biayas' => BiayaProyekResource::collection($this->whenLoaded('biayas')),
        ];
    }
}

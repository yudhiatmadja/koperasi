<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpananBulananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'periode' => $this->periode,
            'saldo_awal' => (int) $this->saldo_awal,
            'total_pokok' => (int) $this->total_pokok,
            'total_wajib' => (int) $this->total_wajib,
            'total_sukarela' => (int) $this->total_sukarela,
            'total_penarikan' => (int) $this->total_penarikan,
            'saldo_akhir' => (int) $this->saldo_akhir,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPiutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik', 'nama', 'tanggal_transaksi', 'keterangan', 'jumlah_pinjaman_baru',
        'jangka_waktu_bulan', 'bayar_pokok', 'bayar_bunga', 'id_pinjaman'
    ];

    public function pinjaman() {
        return $this->belongsTo(Pinjaman::class);
    }
}

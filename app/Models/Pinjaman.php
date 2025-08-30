<?php

namespace App\Models;

use App\Models\User;
use App\Models\TransaksiPiutang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjamans';

    protected $fillable = ['user_nik', 'nama_peminjam_non_anggota', 'tanggal_pinjaman', 'jumlah_pinjaman', 'jangka_waktu_bulan', 'sisa_pokok_pinjaman', 'status'];

    // Satu pinjaman dimiliki oleh satu user
    public function user() {
        return $this->belongsTo(User::class, 'user_nik', 'nik');
    }

    // Satu pinjaman memiliki banyak transaksi piutang (angsuran)
    public function transaksi() {
        return $this->hasMany(TransaksiPiutang::class);
    }

    public function getNamaPeminjamAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->nama_peminjam_non_anggota ?? 'N/A';
    }
}

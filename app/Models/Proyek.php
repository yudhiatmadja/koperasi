<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    
    protected $guarded = ['id']; // Izinkan semua field diisi

    public function tahapans() {
        return $this->hasMany(TahapanProyek::class)->orderBy('urutan');
    }

    public function tagihans() {
        return $this->hasMany(TagihanProyek::class)->orderBy('tanggal_tagihan');
    }

    public function biayas() {
        return $this->hasMany(BiayaProyek::class)->orderBy('tanggal_transaksi');
    }
}

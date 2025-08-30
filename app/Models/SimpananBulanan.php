<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'periode',
        'saldo_awal',
        'saldo_akhir',
        'total_pokok',
        'total_wajib',
        'total_sukarela',
        'total_penarikan',
        'total_tunai',
        'total_bank',
    ];
}

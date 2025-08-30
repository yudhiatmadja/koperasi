<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagihanProyek extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * Menggunakan $guarded adalah cara mudah untuk mengizinkan semua field diisi,
     * kecuali 'id'. Ini aman untuk form internal kita.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Proyek.
     * Ini memberitahu Laravel bahwa satu data tagihan pasti dimiliki oleh satu proyek.
     * Kita memerlukannya untuk mengakses data proyek dari tagihan, contoh: $tagihan->proyek->nama_pekerjaan
     */
    public function proyek(): BelongsTo
    {
        // Laravel secara otomatis akan mencari foreign key 'proyek_id'
        return $this->belongsTo(Proyek::class);
    }
}

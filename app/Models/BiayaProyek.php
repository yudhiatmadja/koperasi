<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiayaProyek extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Proyek.
     * Ini memberitahu Laravel bahwa satu data biaya pasti dimiliki oleh satu proyek.
     */
    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}

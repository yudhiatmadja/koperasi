<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Di setiap model (TahapanProyek, TagihanProyek, BiayaProyek)
class TahapanProyek extends Model // atau TagihanProyek, BiayaProyek
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function proyek() {
        return $this->belongsTo(Proyek::class);
    }
}

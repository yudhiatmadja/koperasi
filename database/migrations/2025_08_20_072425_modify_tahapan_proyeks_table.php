<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tahapan_proyeks', function (Blueprint $table) {
            // Hapus kolom status ENUM yang lama
            $table->dropColumn('status');

            // Tambahkan kolom baru sesuai gambar
            // Kolom ini akan menyimpan pilihan antara 'ADA' atau 'TIDAK_ADA'
            $table->enum('keberadaan', ['ADA', 'TIDAK_ADA'])->nullable()->after('uraian');

            // Kolom ini untuk status teks bebas
            $table->string('status_text')->nullable()->after('keberadaan');
        });
    }

    public function down(): void
    {
        Schema::table('tahapan_proyeks', function (Blueprint $table) {
            // Logika untuk mengembalikan jika migrasi di-rollback
            $table->enum('status', ['BELUM MULAI', 'DALAM PROSES', 'SELESAI', 'DITUNDA'])->default('BELUM MULAI');
            $table->dropColumn('keberadaan');
            $table->dropColumn('status_text');
        });
    }
};

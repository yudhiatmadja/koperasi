<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi_piutangs', function (Blueprint $table) {
            $table->foreignId('pinjaman_id')->nullable()->constrained('pinjamans')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_piutangs', function (Blueprint $table) {
            $table->dropForeign(['pinjaman_id']);
        $table->dropColumn('pinjaman_id');
        });
    }
};

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
        Schema::create('transaksi_piutangs', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 20);
        $table->string('nama', 100);
        $table->date('tanggal_transaksi');
        $table->string('keterangan')->nullable();
        $table->bigInteger('jumlah_pinjaman_baru')->default(0);
        $table->integer('jangka_waktu_bulan')->default(0);
        $table->bigInteger('bayar_pokok')->default(0);
        $table->bigInteger('bayar_bunga')->default(0);
        $table->unsignedBigInteger('id_pinjaman')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_piutangs');
    }
};

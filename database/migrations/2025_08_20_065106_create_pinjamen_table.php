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
        Schema::create('pinjamans', function (Blueprint $table) {
        $table->id();
        $table->string('user_nik', 20); // Foreign key ke NIK di tabel users
        $table->date('tanggal_pinjaman');
        $table->bigInteger('jumlah_pinjaman');
        $table->integer('jangka_waktu_bulan');
        $table->bigInteger('sisa_pokok_pinjaman'); // Sisa pinjaman yang akan berkurang setiap angsuran
        $table->enum('status', ['BELUM LUNAS', 'LUNAS'])->default('BELUM LUNAS');
        $table->timestamps();

        $table->foreign('user_nik')->references('nik')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};

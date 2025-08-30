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
        Schema::create('simpanan_bulanans', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 20);
        $table->string('nama', 100);
        $table->string('periode', 7); // Format 'YYYY-MM'

        $table->bigInteger('saldo_awal')->default(0);
        $table->bigInteger('saldo_akhir')->default(0);
        $table->bigInteger('total_pokok')->default(0);
        $table->bigInteger('total_wajib')->default(0);
        $table->bigInteger('total_sukarela')->default(0);
        $table->bigInteger('total_penarikan')->default(0);
        $table->bigInteger('total_tunai')->default(0);
        $table->bigInteger('total_bank')->default(0);
        $table->timestamps();

        $table->unique(['nik', 'periode']); // Kunci unik
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan_bulanans');
    }
};

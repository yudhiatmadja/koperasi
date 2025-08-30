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
    Schema::create('tagihan_proyeks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proyek_id')->constrained('proyeks')->onDelete('cascade');
        $table->date('tanggal_tagihan');
        $table->bigInteger('jumlah_tagihan');
        $table->date('tanggal_bayar')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_proyeks');
    }
};

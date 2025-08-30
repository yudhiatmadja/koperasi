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
    Schema::create('biaya_proyeks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proyek_id')->constrained('proyeks')->onDelete('cascade');
        $table->date('tanggal_transaksi');
        $table->string('deskripsi');
        $table->bigInteger('jumlah');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_proyeks');
    }
};

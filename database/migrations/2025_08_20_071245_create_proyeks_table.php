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
    Schema::create('proyeks', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pekerjaan');
        $table->string('nomor_proyek', 50)->unique()->nullable();
        $table->date('tanggal_proyek')->nullable();
        $table->bigInteger('nilai_proyek')->default(0);
        $table->date('tanggal_mulai')->nullable();
        $table->date('tanggal_selesai')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};

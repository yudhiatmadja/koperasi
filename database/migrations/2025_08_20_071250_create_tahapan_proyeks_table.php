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
    Schema::create('tahapan_proyeks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proyek_id')->constrained('proyeks')->onDelete('cascade');
        $table->integer('urutan')->nullable();
        $table->string('uraian');
        $table->enum('status', ['BELUM MULAI', 'DALAM PROSES', 'SELESAI', 'DITUNDA'])->default('BELUM MULAI');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapan_proyeks');
    }
};

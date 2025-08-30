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
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->dropForeign(['user_nik']);

            $table->string('user_nik', 20)->nullable()->change();

            $table->foreign('user_nik')->references('nik')->on('users')->onDelete('set null');

            $table->string('nama_peminjam_non_anggota')->nullable()->after('user_nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->dropForeign(['user_nik']);
            $table->dropColumn('nama_peminjam_non_anggota');
            $table->string('user_nik', 20)->nullable(false)->change();
            $table->foreign('user_nik')->references('nik')->on('users')->onDelete('cascade');
        });
    }
};

<?php

/**
 * Migrasi: tambahkan kunci asing ke tabel `users`.
 *
 * Diseparate dari migrasi pembuatan tabel awal agar referensi ke tabel lain
 * sudah ada. Kunci asing ini menghubungkan kolom jenis_tenaga, unit_kerja,
 * dan role ke tabel terkait dengan perilaku hapus yang sesuai.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan foreign key setelah tabel referensi tersedia.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('jenis_tenaga_id')->references('jenis_tenaga_id')->on('jenis_tenagas')->onDelete('set null');
            $table->foreign('unit_kerja_id')->references('unit_kerja_id')->on('unit_kerjas')->onDelete('set null');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Menghapus foreign key ketika rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jenis_tenaga_id']);
            $table->dropForeign(['unit_kerja_id']);
            $table->dropForeign(['role_id']);
        });
    }
};

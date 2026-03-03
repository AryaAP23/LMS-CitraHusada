<?php

/**
 * Migrasi: membuat tabel `materis`.
 *
 * Menyimpan informasi materi pembelajaran, termasuk judul, periode
 * durasi, dan jumlah jam pelajaran.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk tabel `materis`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->bigIncrements('materi_id');
            $table->string('judul');
            $table->date('tanggal_upload');
            $table->date('tanggal_selesai');
            $table->integer('jam_pelajaran');
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel `materis`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};

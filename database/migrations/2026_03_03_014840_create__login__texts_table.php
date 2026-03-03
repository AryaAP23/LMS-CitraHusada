<?php

/**
 * Migrasi: membuat tabel `_login__texts`.
 *
 * Menyimpan teks yang ditampilkan pada layar login, misalnya pesan
 * sambutan atau instruksi singkat. Struktur sederhana dengan kolom teks
 * dan timestamps.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('_login__texts', function (Blueprint $table) {
            $table->bigIncrements('text_id');
            $table->string('text');
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('_login__texts');
    }
};

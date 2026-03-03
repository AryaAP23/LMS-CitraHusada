<?php

/**
 * Migrasi: membuat tabel `post_tests`.
 *
 * Berisi soal ujian akhir (post-test) yang terkait dengan sub-materi.
 * Menyimpan pertanyaan, lima pilihan, jawaban benar, serta flag
 * status pilihan apakah menggunakan opsi berganda atau bukan.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel `post_tests` beserta foreign key ke `sub_materis`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('post_tests', function (Blueprint $table) {
            $table->bigIncrements('post_test_id');
            $table->unsignedBigInteger('sub_materi_id');
            $table->boolean('status_pilihan')->default(false);
            $table->text('soal');
            $table->string('pilihan_1');
            $table->string('pilihan_2');
            $table->string('pilihan_3');
            $table->string('pilihan_4');
            $table->string('pilihan_5');
            $table->string('jawaban_benar');
            $table->timestamps();

            $table->foreign('sub_materi_id')->references('sub_materi_id')->on('sub_materis')->onDelete('cascade');
        });
    }

    /**
     * Hapus tabel `post_tests`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tests');
    }
};

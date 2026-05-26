<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pelanggarans', function (Blueprint $table) {
            $table->id('id_jenis_pelanggaran');
            $table->string('nama_pelanggaran');
            $table->integer('poin_minus')->default(0); // Skor pengurangan poin kedisiplinan
            $table->string('kategori'); // Ringan, Sedang, Berat
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggarans');
    }
};
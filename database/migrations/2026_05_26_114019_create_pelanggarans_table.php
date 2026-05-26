<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->string('id_pelanggaran')->primary(); // Format: PLG-YYYYMM-0001
            
            $table->string('id_santri');
            $table->foreign('id_santri')->references('id_santri')->on('santris')->onDelete('cascade');

            $table->unsignedBigInteger('id_jenis_pelanggaran');
            $table->foreign('id_jenis_pelanggaran')->references('id_jenis_pelanggaran')->on('jenis_pelanggarans')->onDelete('cascade');

            $table->date('tanggal_melanggar');
            $table->text('catatan_tindakan')->nullable(); // Hukuman atau takzir yang diberikan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
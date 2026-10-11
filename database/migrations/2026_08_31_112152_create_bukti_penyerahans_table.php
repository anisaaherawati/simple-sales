<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_penyerahans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_penjualan');

            $table->string('foto');

            $table->text('alasan_penolakan')->nullable();

            $table->enum('status', [
                'menunggu_konfirmasi',
                'ditolak',
                'diterima'
            ])->default('menunggu_konfirmasi');

            $table->timestamp('tanggal_upload')->nullable();

            $table->timestamp('tanggal_konfirmasi')->nullable();

            $table->timestamps();

            $table->foreign('id_penjualan')
                ->references('id_penjualan')
                ->on('penjualan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_penyerahans');
    }
};
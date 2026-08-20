<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('penjualan', function (Blueprint $table) {
        $table->id('id_penjualan');

        $table->unsignedBigInteger('id_pelanggan');
        $table->unsignedBigInteger('id_user');

        $table->string('nomor_penjualan', 30)->unique();
        $table->date('tanggal_penjualan');
        $table->decimal('total_penjualan', 12, 2)->default(0);
        $table->string('status_penjualan', 30);

        $table->date('tanggal_validasi')->nullable();
        $table->string('foto_toko', 255)->nullable();
        $table->string('foto_bukti_penyerahan', 255)->nullable();
        $table->date('tanggal_selesai')->nullable();

        $table->foreign('id_pelanggan')
            ->references('id_pelanggan')
            ->on('pelanggan');

        $table->foreign('id_user')
            ->references('id_user')
            ->on('user');
    });
}

public function down(): void
{
    Schema::dropIfExists('penjualan');
}
};

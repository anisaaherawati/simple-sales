<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail_penjualan');

            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_penjualan');

            $table->integer('jumlah_produk');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk');

            $table->foreign('id_penjualan')
                ->references('id_penjualan')
                ->on('penjualan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};

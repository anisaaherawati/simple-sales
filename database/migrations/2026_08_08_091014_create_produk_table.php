<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('kode_produk', 30)->unique();
            $table->string('nama_produk', 100);
            $table->string('kategori_produk', 100);
            $table->decimal('harga_produk', 12, 2);
            $table->integer('stok_produk');
            $table->string('satuan_produk', 50);
            $table->string('status_produk', 20)->default('aktif');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};

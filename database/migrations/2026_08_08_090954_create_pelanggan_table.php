<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('kode_pelanggan', 30)->unique();
            $table->string('nama_pelanggan', 100);
            $table->string('nama_toko', 100);
            $table->text('alamat_pelanggan');
            $table->string('no_wa', 20);
            $table->string('status_pelanggan', 20)->default('aktif');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};

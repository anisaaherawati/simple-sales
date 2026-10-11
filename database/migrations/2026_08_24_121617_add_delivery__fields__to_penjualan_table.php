<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Kolom sudah tersedia di database.
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Tidak ada perubahan yang perlu dibatalkan.
        });
    }
};
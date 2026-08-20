<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_user', 100);
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('role', 20);
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('status_user', 20)->default('aktif');
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};

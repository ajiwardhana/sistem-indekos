<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_penyewaans_table.php
public function up()
{
    Schema::create('penyewaan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('kamar_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_mulai');
        $table->integer('durasi'); // dalam bulan
        $table->decimal('total_harga', 15, 2);
        $table->enum('status', ['menunggu_pembayaran', 'dibayar', 'dikonfirmasi', 'selesai'])->default('menunggu_pembayaran');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};

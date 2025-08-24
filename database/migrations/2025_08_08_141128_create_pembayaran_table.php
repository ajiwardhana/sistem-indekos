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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewa_id')->constrained('penyewa')->onDelete('cascade'); // Perhatikan perubahan di sini
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal_pembayaran');
            $table->string('metode_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

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
        Schema::create('penyewa', function (Blueprint $table) {
    $table->id();
    
    // Tambahkan kolom tanpa langsung membuat foreign key
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('kamar_id');
    
    $table->date('tanggal_mulai');
    $table->date('tanggal_selesai')->nullable();
    $table->enum('status', ['aktif', 'selesai', 'batal'])->default('aktif');
    $table->timestamps();
    
    // Tambahkan foreign key secara terpisah
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');
          
    $table->foreign('kamar_id')
          ->references('id')
          ->on('kamar')
          ->onDelete('cascade');
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewa');
    }
};

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
        Schema::create('penyewaan', function (Blueprint $table) {
        $table->id();
        
        // Gunakan constraint dengan nama unik
        $table->foreignId('user_id')
              ->constrained('users', 'id', 'uniq_penyewaan_user')
              ->onDelete('cascade');
              
        $table->foreignId('kamar_id')
              ->constrained('kamar', 'id', 'uniq_penyewaan_kamar')
              ->onDelete('cascade');
        
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai')->nullable();
        $table->enum('status', ['aktif', 'selesai', 'batal'])->default('aktif');
        $table->timestamps();
    });

Schema::table('penyewaan', function (Blueprint $table) {
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('kamar_id')->references('id')->on('kamar')->onDelete('cascade');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Check if the 'kamar' table does not exist before creating it
    if (!Schema::hasTable('kamar')) {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->decimal('harga', 10, 2);
            $table->text('fasilitas');
            $table->enum('status', ['tersedia', 'terisi', 'perbaikan'])->default('tersedia');
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};

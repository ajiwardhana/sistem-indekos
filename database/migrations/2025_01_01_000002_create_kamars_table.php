<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->decimal('harga', 10, 2);
            $table->enum('status', ['tersedia','terisi','perbaikan','pending'])->default('tersedia');
            $table->string('fasilitas')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // di migration kamars
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamars');
    }
};

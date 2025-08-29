<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurasiToPenyewaanTable extends Migration
{
    public function up()
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->integer('durasi')->after('tanggal_mulai')->nullable();
        });
    }

    public function down()
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->dropColumn('durasi');
        });
    }
}
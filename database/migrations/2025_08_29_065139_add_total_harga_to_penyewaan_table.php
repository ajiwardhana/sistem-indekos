<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalHargaToPenyewaanTable extends Migration
{
    public function up()
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->decimal('total_harga', 15, 2)->after('durasi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->dropColumn('total_harga');
        });
    }
}
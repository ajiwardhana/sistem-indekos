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
    Schema::table('penyewa', function (Blueprint $table) {
        
        $table->index('user_id');
        $table->index('status');
    });
    
    Schema::table('pembayaran', function (Blueprint $table) {
        if (!Schema::hasIndex('pembayaran', 'pembayaran_tanggal_pembayaran_index')) {
            $table->index('tanggal_pembayaran', 'idx_tanggal_pembayaran');
        }
        $table->index('penyewa_id');
        $table->index('tanggal_pembayaran');
    });

    
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};

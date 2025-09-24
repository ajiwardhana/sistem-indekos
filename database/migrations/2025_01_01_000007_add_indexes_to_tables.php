<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Index untuk users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('email');
        });

        // Index untuk kamar table
        Schema::table('kamars', function (Blueprint $table) {
            $table->index('status');
            $table->index('nomor_kamar');
        });

        // Index untuk penyewas table (jika ada)
        if (Schema::hasTable('penyewas')) {
            Schema::table('penyewas', function (Blueprint $table) {
                $table->index('user_id');
                $table->index('kamar_id');
                $table->index('status');
            });
        }

        // Index untuk pembayarans table
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->index('penyewa_id');
            $table->index('kamar_id');
            $table->index('status');
            $table->index(['bulan', 'tahun']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['email']);
        });

        Schema::table('kamars', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['nomor_kamar']);
        });

        if (Schema::hasTable('penyewas')) {
            Schema::table('penyewas', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
                $table->dropIndex(['kamar_id']);
                $table->dropIndex(['status']);
            });
        }

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropIndex(['penyewa_id']);
            $table->dropIndex(['kamar_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['bulan', 'tahun']);
        });
    }
};
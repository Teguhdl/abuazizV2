<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->enum('jenis_pendapatan', ['sekolah', 'yayasan'])
                  ->after('kode')
                  ->default('sekolah');
        });
    }

    public function down(): void
    {
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->dropColumn('jenis_pendapatan');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->date('tanggal_pendapatan')->after('nama')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->dropColumn('tanggal_pendapatan');
        });
    }
};

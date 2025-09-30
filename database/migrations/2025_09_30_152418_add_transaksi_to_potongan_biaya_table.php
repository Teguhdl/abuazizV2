<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('potongan_biaya', function (Blueprint $table) {
            $table->enum('transaksi', ['pendaftaran', 'daftar_ulang'])
                  ->default('pendaftaran')
                  ->after('sekolah_id')
                  ->comment('Jenis transaksi potongan ini');
        });
    }

    public function down(): void
    {
        Schema::table('potongan_biaya', function (Blueprint $table) {
            $table->dropColumn('transaksi');
        });
    }
};

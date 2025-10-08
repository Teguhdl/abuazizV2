<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_pendaftaran', function (Blueprint $table) {
            // Tambahkan kolom potongan_id nullable
            $table->foreignId('potongan_id')
                ->nullable()
                ->after('biaya_total')
                ->constrained('potongan_biaya')
                ->nullOnDelete(); // jika potongan dihapus, set null
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['potongan_id']);
            $table->dropColumn('potongan_id');
        });
    }
};

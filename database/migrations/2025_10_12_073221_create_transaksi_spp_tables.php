<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengaturan SPP
        Schema::create('pengaturan_spp', function (Blueprint $table) {
            $table->id();
            $table->decimal('nominal', 15, 2)->comment('Nominal SPP per bulan');
            $table->year('tahun_ajaran')->comment('Tahun ajaran aktif');
            $table->timestamps();
        });

        // Transaksi SPP
        Schema::create('transaksi_spp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->string('nomor_transaksi')->unique();
            $table->date('tanggal_bayar');
            $table->decimal('total_bayar', 15, 2);
            $table->string('metode_pembayaran')->nullable(); // tunai / transfer
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Detail bulan pembayaran
        Schema::create('transaksi_spp_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_spp_id')->constrained('transaksi_spp')->cascadeOnDelete();
            $table->enum('bulan', [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ]);
            $table->year('tahun');
            $table->decimal('nominal', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_spp_detail');
        Schema::dropIfExists('transaksi_spp');
        Schema::dropIfExists('pengaturan_spp');
    }
};

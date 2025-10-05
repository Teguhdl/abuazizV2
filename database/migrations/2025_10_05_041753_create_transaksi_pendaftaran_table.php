<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->string('no_pendaftaran')->unique();
            $table->date('tanggal_daftar');
            $table->decimal('biaya_total', 15, 2);
            $table->decimal('total_dibayar', 15, 2)->default(0);
            $table->decimal('sisa_pembayaran', 15, 2)->virtualAs('biaya_total - total_dibayar');
            $table->string('metode_pembayaran', 50)->nullable()->comment('Tunai, Transfer, dll');
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_pendaftaran');
    }
};

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
        Schema::create('transaksi_daftar_ulang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('no_daftar_ulang')->unique();
            $table->date('tanggal_daftar');
            $table->decimal('biaya_total', 12, 2);
            $table->foreignId('potongan_id')->nullable()->constrained('potongan_biaya')->nullOnDelete();
            $table->decimal('total_dibayar', 12, 2);
            $table->string('metode_pembayaran');
            $table->string('jenis_pembayaran');
            $table->string('status');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_daftar_ulang');
    }
};

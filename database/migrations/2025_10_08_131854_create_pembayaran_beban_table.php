<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_beban', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pembayaran');
            $table->string('no_akun', 25); // harus sama tipe dengan primary key akun
            $table->decimal('nominal', 15, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // foreign key manual
            $table->foreign('no_akun')->references('no_akun')->on('akun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_beban');
    }
};

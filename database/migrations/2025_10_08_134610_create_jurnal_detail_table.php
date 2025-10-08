<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurnal_header_id')->constrained('jurnal_header')->onDelete('cascade');
            $table->string('coa_id', 25); // sesuai no_akun
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Foreign key ke tabel akun
            $table->foreign('coa_id')->references('no_akun')->on('akun')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_detail');
    }
};

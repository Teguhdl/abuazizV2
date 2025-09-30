<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment('Nama sekolah');
            $table->text('alamat')->nullable()->comment('Alamat sekolah');
            $table->string('jenis')->nullable()->comment('Jenis sekolah (SD, TK, SMP, dll.)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};

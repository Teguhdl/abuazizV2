<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('potongan_biaya', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->decimal('jumlah', 15, 2); // nominal potongan
            $table->foreignId('sekolah_id')->constrained('sekolah')->onDelete('cascade'); // relasi ke sekolah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('potongan_biaya');
    }
};

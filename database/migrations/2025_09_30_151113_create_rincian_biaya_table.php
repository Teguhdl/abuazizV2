<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rincian_biaya', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->decimal('jumlah', 15, 2);
            $table->foreignId('sekolah_id')->constrained('sekolah')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rincian_biaya');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique()->comment('Nomor Induk Siswa'); 
            $table->string('nama')->comment('Nama lengkap siswa');
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('Laki-laki / Perempuan');
            $table->date('tanggal_lahir')->comment('Tanggal lahir siswa');
            $table->string('tempat_lahir')->nullable()->comment('Tempat lahir siswa');
            $table->text('alamat')->nullable()->comment('Alamat lengkap siswa');
            $table->string('telepon')->nullable()->comment('Nomor telepon siswa');
            $table->string('nama_ayah')->nullable()->comment('Nama ayah siswa');
            $table->string('telepon_ayah')->nullable()->comment('No telepon ayah siswa');
            $table->string('nama_ibu')->nullable()->comment('Nama ibu siswa');
            $table->string('telepon_ibu')->nullable()->comment('No telepon ibu siswa');
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete()->comment('Relasi ke tabel kelas');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->comment('Status siswa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};

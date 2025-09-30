<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // nama lengkap
            $table->string('username')->unique();    // username unik
            $table->string('email')->unique();       // email unik
            $table->string('password');              // password (bcrypt/hashed)
            $table->enum('role', ['admin', 'user'])->default('user'); // role akses
            $table->rememberToken();                 // token "remember me"
            $table->timestamps();                    // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

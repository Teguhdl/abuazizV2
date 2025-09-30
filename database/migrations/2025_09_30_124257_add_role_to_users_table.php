<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddRoleToUsersTable extends Migration
{
    public function up(): void
    {
        DB::statement("
    ALTER TABLE users 
    MODIFY role ENUM('admin', 'user', 'tata_usaha', 'ketua_yayasan', 'bendahara_yayasan', 'operasional_kesiswaan') 
    NOT NULL DEFAULT 'user'
");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM('admin','user') 
            NOT NULL DEFAULT 'user'
        ");
    }
}

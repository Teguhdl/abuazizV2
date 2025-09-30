<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'no_akun';
    public $incrementing = false; // karena primary key bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'no_akun',
        'nama_akun',
        'jenis_akun',
    ];
}

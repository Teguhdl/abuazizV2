<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranBeban extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_beban';

    protected $fillable = [
        'tanggal_pembayaran',
        'no_akun',
        'nominal',
        'keterangan',
    ];


    public function akun()
    {
        return $this->belongsTo(Akun::class, 'no_akun', 'no_akun');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDaftarUlang extends Model
{
    use HasFactory;

    protected $table = 'transaksi_daftar_ulang';

    protected $fillable = [
        'siswa_id',
        'no_daftar_ulang',
        'tanggal_daftar',
        'biaya_total',
        'potongan_id',
        'total_dibayar',
        'metode_pembayaran',
        'jenis_pembayaran',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function potongan()
    {
        return $this->belongsTo(PotonganBiaya::class);
    }
}

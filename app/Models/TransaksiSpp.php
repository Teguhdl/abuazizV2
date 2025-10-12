<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSpp extends Model
{
    use HasFactory;

    protected $table = 'transaksi_spp';

    protected $fillable = [
        'siswa_id',
        'nomor_transaksi',
        'tanggal_bayar',
        'total_bayar',
        'metode_pembayaran',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function detail()
    {
        return $this->hasMany(TransaksiSppDetail::class, 'transaksi_spp_id');
    }
}

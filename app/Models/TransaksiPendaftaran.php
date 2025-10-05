<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pendaftaran';

    protected $fillable = [
        'siswa_id',
        'no_pendaftaran',
        'tanggal_daftar',
        'biaya_total',
        'total_dibayar',
        'metode_pembayaran',
        'status',
    ];

    protected $appends = ['sisa_pembayaran'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function getSisaPembayaranAttribute()
    {
        return $this->biaya_total - $this->total_dibayar;
    }

    public function potongan()
    {
        return $this->belongsTo(PotonganBiaya::class, 'potongan_id');
    }
}

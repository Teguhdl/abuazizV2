<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSppDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_spp_detail';

    protected $fillable = [
        'transaksi_spp_id',
        'bulan',
        'tahun',
        'nominal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiSpp::class, 'transaksi_spp_id');
    }
}

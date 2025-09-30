<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianBiaya extends Model
{
    use HasFactory;

    protected $table = 'rincian_biaya';

    protected $fillable = [
        'nama',
        'jumlah',
        'sekolah_id',
        'transaksi'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}

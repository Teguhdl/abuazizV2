<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanSpp extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_spp';

    protected $fillable = [
        'tahun_ajaran',
        'nominal',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiSpp::class, 'pengaturan_spp_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalHeader extends Model
{
    use HasFactory;

    protected $table = 'jurnal_header';
    protected $fillable = [
        'nomor_jurnal',
        'tanggal',
        'keterangan',
    ];

    public function details()
    {
        return $this->hasMany(JurnalDetail::class, 'jurnal_header_id');
    }
}

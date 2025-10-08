<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    use HasFactory;

    protected $table = 'jurnal_detail';
    protected $fillable = [
        'jurnal_header_id',
        'coa_id',
        'debit',
        'kredit',
        'keterangan',
    ];

    public function header()
    {
        return $this->belongsTo(JurnalHeader::class, 'jurnal_header_id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'coa_id', 'no_akun');
    }
}

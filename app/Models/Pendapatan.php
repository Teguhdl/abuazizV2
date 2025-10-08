<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $table = 'pendapatan';

    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
        'tanggal_pendapatan',
        'nominal',
    ];
}

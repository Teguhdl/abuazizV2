<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'telepon',
        'nama_ayah',
        'telepon_ayah',
        'nama_ibu',
        'telepon_ibu',
        'kelas_id',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

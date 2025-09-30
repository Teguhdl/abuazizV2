<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Aktiva
            ['no_akun' => '111', 'nama_akun' => 'Kas', 'jenis_akun' => 'aktiva'],
            ['no_akun' => '112', 'nama_akun' => 'Piutang SPP', 'jenis_akun' => 'aktiva'],
            ['no_akun' => '113', 'nama_akun' => 'Pembelian', 'jenis_akun' => 'aktiva'],
            ['no_akun' => '121', 'nama_akun' => 'Piutang Pendaftaran', 'jenis_akun' => 'aktiva'],
            ['no_akun' => '122', 'nama_akun' => 'Piutang Daftar Ulang', 'jenis_akun' => 'aktiva'],
            ['no_akun' => '123', 'nama_akun' => 'Perlengkapan', 'jenis_akun' => 'aktiva'],
            ['no_akun' => '124', 'nama_akun' => 'Peralatan', 'jenis_akun' => 'aktiva'],

            // Kewajiban
            ['no_akun' => '211', 'nama_akun' => 'Utang', 'jenis_akun' => 'pasiva'],

            // Pendapatan
            ['no_akun' => '411', 'nama_akun' => 'Pendapatan SPP', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '421', 'nama_akun' => 'Pendapatan Pendaftaran', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '422', 'nama_akun' => 'Pendapatan Daftar Ulang', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '423', 'nama_akun' => 'Pendapatan Lain-Lain', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '424', 'nama_akun' => 'Pendapatan Dana Terikat', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '425', 'nama_akun' => 'Diskon Pendaftaran', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '426', 'nama_akun' => 'Diskon Daftar Ulang', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '427', 'nama_akun' => 'Pendapatan DUPI', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '428', 'nama_akun' => 'Pendapatan Dana Bos', 'jenis_akun' => 'pasiva'],
            ['no_akun' => '429', 'nama_akun' => 'Pendapatan Dana Tidak Terikat', 'jenis_akun' => 'pasiva'],

            // Beban
            ['no_akun' => '511', 'nama_akun' => 'Beban Air', 'jenis_akun' => 'beban'],
            ['no_akun' => '512', 'nama_akun' => 'Beban Gaji', 'jenis_akun' => 'beban'],
            ['no_akun' => '513', 'nama_akun' => 'Beban Listrik', 'jenis_akun' => 'beban'],
            ['no_akun' => '514', 'nama_akun' => 'Beban Internet', 'jenis_akun' => 'beban'],
            ['no_akun' => '515', 'nama_akun' => 'Beban Kendaraan', 'jenis_akun' => 'beban'],
            ['no_akun' => '516', 'nama_akun' => 'Beban Telepon', 'jenis_akun' => 'beban'],
        ];

        DB::table('akun')->insert($data);
    }
}

@extends('layouts.app')

@section('title', 'Detail Daftar Ulang')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Detail Transaksi Daftar Ulang</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Data Daftar Ulang</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>No Daftar Ulang:</strong> {{ $data->no_daftar_ulang }}</p>
                <p><strong>Tanggal Daftar:</strong> {{ \Carbon\Carbon::parse($data->tanggal_daftar)->format('d M Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="px-2 py-1 rounded text-white {{ $data->status == 'lunas' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($data->status) }}
                    </span>
                </p>
                <p><strong>Jenis Pembayaran:</strong> {{ $data->jenis_pembayaran }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $data->metode_pembayaran }}</p>
            </div>

            <div>
                <p><strong>Total Biaya:</strong> Rp {{ number_format($data->biaya_total, 0, ',', '.') }}</p>
                <p><strong>Potongan:</strong> 
                    {{ $data->potongan ? $data->potongan->nama . ' (' . $data->potongan->jumlah . '%)' : '-' }}
                </p>
                <p><strong>Total Dibayar:</strong> Rp {{ number_format($data->total_dibayar, 0, ',', '.') }}</p>
                <p><strong>Sisa Pembayaran:</strong> 
                    Rp {{ number_format($data->biaya_total - $data->total_dibayar, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-bold mb-4">Data Siswa</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>NIS:</strong> {{ $data->siswa->nis }}</p>
                <p><strong>Nama:</strong> {{ $data->siswa->nama }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $data->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p><strong>Kelas:</strong> {{ $data->siswa->kelas->nama ?? '-' }}</p>
            </div>

            <div>
                <p><strong>Tempat, Tanggal Lahir:</strong> {{ $data->siswa->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($data->siswa->tanggal_lahir)->format('d M Y') }}
                </p>
                <p><strong>Alamat:</strong> {{ $data->siswa->alamat }}</p>
                <p><strong>Telepon:</strong> {{ $data->siswa->telepon }}</p>
            </div>
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-bold mb-4">Data Orang Tua</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>Nama Ayah:</strong> {{ $data->siswa->nama_ayah }}</p>
                <p><strong>Telepon Ayah:</strong> {{ $data->siswa->telepon_ayah }}</p>
            </div>
            <div>
                <p><strong>Nama Ibu:</strong> {{ $data->siswa->nama_ibu }}</p>
                <p><strong>Telepon Ibu:</strong> {{ $data->siswa->telepon_ibu }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('transaksi_daftar_ulang.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection

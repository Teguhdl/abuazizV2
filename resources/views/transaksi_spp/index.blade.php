@extends('layouts.app')

@section('title', 'Data Transaksi SPP')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Data Transaksi SPP</h2>
        <a href="{{ route('transaksi-spp.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">+ Tambah Transaksi</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Tanggal Bayar</th>
                    <th class="p-3 text-left">Nomor Transaksi</th>
                    <th class="p-3 text-left">Nama Siswa</th>
                    <th class="p-3 text-right">Total Bayar</th>
                    <th class="p-3 text-left">Metode</th>
                    <th class="p-3 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $key => $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $key + 1 }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $item->nomor_transaksi }}</td>
                        <td class="p-3">{{ $item->siswa->nama ?? '-' }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        <td class="p-3">{{ ucfirst($item->metode_pembayaran ?? '-') }}</td>
                        <td class="p-3">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-500">Belum ada transaksi SPP.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

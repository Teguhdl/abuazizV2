@extends('layouts.app')

@section('title', 'Daftar Ulang Siswa')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Daftar Ulang Siswa</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Data Transaksi Daftar Ulang</h2>
            <a href="{{ route('transaksi_daftar_ulang.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Daftar Ulang
            </a>
        </div>

        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr class="text-left text-gray-700">
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">NIS</th>
                        <th class="px-4 py-2 border">Nama Siswa</th>
                        <th class="px-4 py-2 border">Kelas</th>
                        <th class="px-4 py-2 border">Tanggal Daftar Ulang</th>
                        <th class="px-4 py-2 border">Metode Pembayaran</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Total Biaya</th>
                        <th class="px-4 py-2 border">Total Bayar</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $item->siswa->nis }}</td>
                            <td class="px-4 py-2 border">{{ $item->siswa->nama }}</td>
                            <td class="px-4 py-2 border">{{ $item->siswa->kelas->nama ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->tanggal_daftar_ulang)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 border">{{ $item->metode_pembayaran }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 text-sm rounded 
                                    {{ $item->jenis_pembayaran == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">Rp {{ number_format($item->biaya_total, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('transaksi_daftar_ulang.show', $item->id) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Detail</a>
                                    <!-- <a href="{{ route('transaksi_daftar_ulang.edit', $item->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Edit</a> -->
                                    <!-- <form action="{{ route('transaksi_daftar_ulang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                            Hapus
                                        </button>
                                    </form> -->
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">Belum ada data daftar ulang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

      
    </div>
</div>
@endsection

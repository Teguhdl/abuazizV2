@extends('layouts.app')

@section('title', 'Daftar Potongan Biaya')
@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection
@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Potongan Biaya</h2>
        <a href="{{ route('potongan_biaya.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Tambah
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b">No</th>
                    <th class="px-4 py-2 border-b">Nama</th>
                    <th class="px-4 py-2 border-b">Transaksi</th>
                    <th class="px-4 py-2 border-b">Jumlah</th>
                    <th class="px-4 py-2 border-b">Sekolah</th>
                    <th class="px-4 py-2 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($potongan as $r)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-b">{{ $r->nama }}</td>
                    <td class="px-4 py-2 border-b">{{ $r->transaksi }}</td>
                    <td class="px-4 py-2 border-b">{{ number_format($r->jumlah,2,',','.') }}</td>
                    <td class="px-4 py-2 border-b">{{ $r->sekolah->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border-b text-center space-x-2">
                        <a href="{{ route('potongan_biaya.edit', $r->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Edit</a>
                        <form action="{{ route('potongan_biaya.destroy', $r->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

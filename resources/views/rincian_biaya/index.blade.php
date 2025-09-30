@extends('layouts.app')

@section('title', 'Daftar Rincian Biaya')
@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection
@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Rincian Biaya</h2>
        <a href="{{ route('rincian_biaya.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Tambah
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b  text-center">No</th>
                    <th class="px-4 py-2 border-b  text-center">Nama</th>
                    <th class="px-4 py-2 border-b  text-center">Transaksi</th>
                    <th class="px-4 py-2 border-b  text-center">Jumlah</th>
                    <th class="px-4 py-2 border-b  text-center">Sekolah</th>
                    <th class="px-4 py-2 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rincian as $r)
                <tr>
                    <td class="px-4 py-2 border-b  text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-b  text-center">{{ $r->nama }}</td>
                    <td class="px-4 py-2 border-b  text-center">{{ $r->transaksi }}</td>
                    <td class="px-4 py-2 border-b  text-center">{{ number_format($r->jumlah,2,',','.') }}</td>
                    <td class="px-4 py-2 border-b  text-center">{{ $r->sekolah->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border-b text-center space-x-2">
                        <a href="{{ route('rincian_biaya.edit', $r->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Edit</a>
                        <form action="{{ route('rincian_biaya.destroy', $r->id) }}" method="POST" class="inline">
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

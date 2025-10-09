@extends('layouts.app')

@section('title', 'Master Pendapatan')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Data Pendapatan</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Daftar Pendapatan</h2>
            <a href="{{ route('pendapatan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</a>
        </div>

        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Kode</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Tanggal Pendapatan</th>
                    <th class="border px-4 py-2">Nominal</th>
                    <th class="border px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $item->kode }}</td>
                        <td class="border px-4 py-2">{{ $item->nama }}</td>
                        <td class="border px-4 py-2">
                            {{ \Carbon\Carbon::parse($item->tanggal_pendapatan)->format('d-m-Y') }}
                        </td>
                        <td class="border px-4 py-2">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

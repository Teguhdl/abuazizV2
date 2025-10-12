@extends('layouts.app')

@section('title', 'Pengaturan SPP')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Pengaturan SPP</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Daftar Pengaturan SPP</h2>
            <a href="{{ route('pengaturan-spp.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Tambah
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Tahun Ajaran</th>
                    <th class="border px-4 py-2">Nominal</th>
                    <th class="border px-4 py-2 w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $item->tahun_ajaran }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('pengaturan-spp.edit', $item->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                            <form action="{{ route('pengaturan-spp.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Belum ada data pengaturan SPP</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

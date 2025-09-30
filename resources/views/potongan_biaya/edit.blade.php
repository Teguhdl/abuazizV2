@extends('layouts.app')

@section('title', 'Edit potongan Biaya')

@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Edit potongan Biaya</h2>

        <form action="{{ route('potongan_biaya.update', $potongan_biaya->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nama potongan Biaya -->
            <div>
                <label class="block text-gray-700 mb-1">Nama potongan Biaya</label>
                <input type="text" name="nama" value="{{ old('nama', $potongan_biaya->nama) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Jumlah -->
            <div>
                <label class="block text-gray-700 mb-1">Jumlah</label>
                <input type="number" step="0.01" name="jumlah" value="{{ old('jumlah', $potongan_biaya->jumlah) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('jumlah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sekolah -->
            <div>
                <label class="block text-gray-700 mb-1">Sekolah</label>
                <select name="sekolah_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($sekolah as $s)
                        <option value="{{ $s->id }}" {{ old('sekolah_id', $potongan_biaya->sekolah_id) == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }}
                        </option>
                    @endforeach
                </select>
                @error('sekolah_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Transaksi -->
            <div>
                <label class="block text-gray-700 mb-1">Transaksi</label>
                <select name="transaksi"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="pendaftaran" {{ old('transaksi', $potongan_biaya->transaksi) == 'pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                    <option value="daftar_ulang" {{ old('transaksi', $potongan_biaya->transaksi) == 'daftar_ulang' ? 'selected' : '' }}>Daftar Ulang</option>
                </select>
                @error('transaksi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update</button>
                <a href="{{ route('potongan_biaya.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

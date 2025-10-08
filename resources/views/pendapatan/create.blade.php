@extends('layouts.app')

@section('title', 'Tambah Pendapatan')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Tambah Pendapatan</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('pendapatan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Tanggal Pendapatan</label>
                <input type="date" name="tanggal_pendapatan" 
                       class="w-full border rounded p-2 @error('tanggal_pendapatan') border-red-500 @enderror"
                       value="{{ old('tanggal_pendapatan', date('Y-m-d')) }}" required>
                @error('tanggal_pendapatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nama Pendapatan</label>
                <input type="text" name="nama" 
                       class="w-full border rounded p-2 @error('nama') border-red-500 @enderror"
                       value="{{ old('nama') }}" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nominal</label>
                <input type="number" name="nominal" step="0.01"
                       class="w-full border rounded p-2 @error('nominal') border-red-500 @enderror"
                       value="{{ old('nominal') }}" required>
                @error('nominal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded p-2">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('pendapatan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

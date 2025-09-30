@extends('layouts.app')

@section('title', 'Tambah Sekolah')
@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection
@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Sekolah</h2>

        <form action="{{ route('sekolah.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1">Nama Sekolah</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Jenis Sekolah</label>
                <select name="jenis" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Jenis Sekolah --</option>
                    <option value="SD" {{ old('jenis') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ old('jenis') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ old('jenis') == 'SMA' ? 'selected' : '' }}>SMA</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('sekolah.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

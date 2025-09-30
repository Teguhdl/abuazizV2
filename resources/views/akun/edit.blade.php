@extends('layouts.app')

@section('title', 'Edit Akun')

@section('breadcrumb')
    <h1 class="text-xl font-semibold"></h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <!-- Card putih -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Edit Akun</h2>

        <form action="{{ route('akun.update', $akun->no_akun) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 mb-1">Nomor Akun</label>
                <input type="text" name="no_akun" value="{{ old('no_akun', $akun->no_akun) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                    readonly>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Nama Akun</label>
                <input type="text" name="nama_akun" value="{{ old('nama_akun', $akun->nama_akun) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Jenis Akun</label>
                <select name="jenis_akun"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Jenis Akun --</option>
                    <option value="aktiva" {{ old('jenis_akun', $akun->jenis_akun) == 'aktiva' ? 'selected' : '' }}>Aktiva</option>
                    <option value="passiva" {{ old('jenis_akun', $akun->jenis_akun) == 'passiva' ? 'selected' : '' }}>Passiva</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('akun.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

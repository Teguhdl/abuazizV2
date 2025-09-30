@extends('layouts.app')

@section('title', 'Tambah Akun')

@section('breadcrumb')
    <h1 class="text-xl font-semibold"></h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <!-- Breadcrumb -->


    <!-- Card putih -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Akun</h2>

        <form action="{{ route('akun.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1">Nomor Akun</label>
                <input type="text" name="no_akun" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Nama Akun</label>
                <input type="text" name="nama_akun" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Jenis Akun</label>
                <select name="jenis_akun" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Jenis Akun --</option>
                    <option value="passiva">Passiva</option>
                    <option value="aktiva">Aktiva</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
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

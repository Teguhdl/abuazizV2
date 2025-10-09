@extends('layouts.app')

@section('title', 'Edit Siswa')
@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Edit Data Siswa</h2>

        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- NIS --}}
            <div>
                <label class="block text-gray-700 mb-1">NIS</label>
                <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" readonly>
            </div>

            {{-- Nama --}}
            <div>
                <label class="block text-gray-700 mb-1">Nama Siswa</label>
                <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Tempat Lahir --}}
            <div>
                <label class="block text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label class="block text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block text-gray-700 mb-1">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $siswa->telepon) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Nama Ayah --}}
            <div>
                <label class="block text-gray-700 mb-1">Nama Ayah</label>
                <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Telepon Ayah --}}
            <div>
                <label class="block text-gray-700 mb-1">Telepon Ayah</label>
                <input type="text" name="telepon_ayah" value="{{ old('telepon_ayah', $siswa->telepon_ayah) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Nama Ibu --}}
            <div>
                <label class="block text-gray-700 mb-1">Nama Ibu</label>
                <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Telepon Ibu --}}
            <div>
                <label class="block text-gray-700 mb-1">Telepon Ibu</label>
                <input type="text" name="telepon_ibu" value="{{ old('telepon_ibu', $siswa->telepon_ibu) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block text-gray-700 mb-1">Kelas</label>
                <select name="kelas_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }} ({{ $k->sekolah->nama ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">-- Pilih Status --</option>
                    <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $siswa->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex space-x-2 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('siswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

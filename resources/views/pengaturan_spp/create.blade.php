@extends('layouts.app')

@section('title', 'Tambah Pengaturan SPP')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Tambah Pengaturan SPP</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
        <form action="{{ route('pengaturan-spp.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="border rounded w-full p-2" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @php
                    $tahunSekarang = date('Y');
                    $tahunMulai = $tahunSekarang - 5; // misal tampilkan 5 tahun ke belakang
                    $tahunAkhir = $tahunSekarang + 5; // dan 5 tahun ke depan
                    @endphp
                    @for ($i = $tahunMulai; $i <= $tahunAkhir; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Nominal (Rp)</label>
                <input type="number" name="nominal" class="border rounded w-full p-2" placeholder="Contoh: 150000" required>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('pengaturan-spp.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
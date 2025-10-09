@extends('layouts.app')

@section('title', 'Bayar Sisa Pendaftaran')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Pelunasan Pendaftaran</h1>
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
    <h2 class="text-lg font-bold mb-4">Form Pelunasan Pendaftaran</h2>

    <form action="{{ route('transaksi_pendaftaran.bayar.store', $data->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Siswa</label>
            <input type="text" value="{{ $data->siswa->nama }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Sisa Pembayaran</label>
            <input type="text" value="Rp {{ number_format($data->sisa_pembayaran, 0, ',', '.') }}"
                class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Jumlah yang Dibayar Sekarang</label>
            <input type="number" name="jumlah_bayar" class="w-full border rounded px-3 py-2" required min="1"
                max="{{ $data->sisa_pembayaran }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="w-full border rounded px-3 py-2" required>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('transaksi_pendaftaran.index') }}" class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
        </div>
    </form>
</div>
@endsection

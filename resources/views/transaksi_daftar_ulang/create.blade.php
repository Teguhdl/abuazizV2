@extends('layouts.app')

@section('title', 'Tambah Daftar Ulang')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Tambah Transaksi Daftar Ulang</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Form Daftar Ulang Siswa</h2>

        <form action="{{ route('transaksi_daftar_ulang.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- PILIH SISWA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-1">Pilih Siswa</label>
                    <select name="siswa_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nis }} - {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', now()->toDateString()) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
            </div>

            {{-- PEMBAYARAN --}}
            <h3 class="text-lg font-semibold mt-6">Data Pembayaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Total biaya dasar --}}
                <div>
                    <label class="block text-gray-700 mb-1">Total Biaya Daftar Ulang</label>
                    <input type="text" id="biaya_total_display" 
                        value="Rp {{ number_format($biayaTotal, 0, ',', '.') }}" readonly
                        class="w-full border border-gray-300 bg-gray-100 rounded-lg px-4 py-2 text-gray-600">
                </div>

                {{-- Potongan --}}
                <div>
                    <label class="block text-gray-700 mb-1">Potongan Biaya (%)</label>
                    <select name="potongan_id" id="potongan_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Tidak Ada</option>
                        @foreach ($potongan as $p)
                            <option value="{{ $p->id }}" data-persentase="{{ $p->jumlah }}"
                                {{ old('potongan_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->jumlah }}%)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Total setelah potongan --}}
                <div>
                    <label class="block text-gray-700 mb-1">Total Setelah Potongan</label>
                    <input type="text" id="total_setelah_potongan_display"
                        value="Rp {{ number_format($biayaTotal, 0, ',', '.') }}" readonly
                        class="w-full border border-gray-300 bg-gray-100 rounded-lg px-4 py-2 text-gray-700 font-semibold">
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <label class="block text-gray-700 mb-1">Metode Pembayaran</label>
                    <select name="metode_pembayaran"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="Tunai" {{ old('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Transfer" {{ old('metode_pembayaran') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>

                {{-- Jenis Pembayaran --}}
                <div>
                    <label class="block text-gray-700 mb-1">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" id="jenis_pembayaran"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Lunas" {{ old('jenis_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Kredit" {{ old('jenis_pembayaran') == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                </div>

                {{-- Jumlah dibayar --}}
                <div>
                    <label class="block text-gray-700 mb-1">Jumlah Dibayar</label>
                    <input type="number" step="0.01" name="total_dibayar" id="total_dibayar"
                        value="{{ old('total_dibayar') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="flex space-x-2 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('transaksi_daftar_ulang.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT PERHITUNGAN --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const biayaTotal = {{ $biayaTotal }};
        const potonganSelect = document.getElementById('potongan_id');
        const jenisPembayaran = document.getElementById('jenis_pembayaran');
        const totalDibayarInput = document.getElementById('total_dibayar');
        const totalSetelahPotonganDisplay = document.getElementById('total_setelah_potongan_display');

        function formatRupiah(num) {
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        function hitungTotal() {
            let potonganPersen = 0;
            if (potonganSelect.value) {
                potonganPersen = parseFloat(potonganSelect.selectedOptions[0].dataset.persentase) || 0;
            }
            const totalSetelahPotongan = biayaTotal - (biayaTotal * potonganPersen / 100);

            totalSetelahPotonganDisplay.value = formatRupiah(totalSetelahPotongan);

            if (jenisPembayaran.value === 'Lunas') {
                totalDibayarInput.value = totalSetelahPotongan.toFixed(0);
                totalDibayarInput.readOnly = true;
            } else {
                totalDibayarInput.readOnly = false;
            }
        }

        potonganSelect.addEventListener('change', hitungTotal);
        jenisPembayaran.addEventListener('change', hitungTotal);
        hitungTotal(); // inisialisasi awal
    });
</script>
@endsection

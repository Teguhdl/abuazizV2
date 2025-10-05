@extends('layouts.app')

@section('title', 'Tambah Pendaftaran')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Tambah Transaksi Pendaftaran</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Form Pendaftaran Siswa Baru</h2>

        <form action="{{ route('transaksi_pendaftaran.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- DATA SISWA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-1">Nis Siswa</label>
                    <input type="number" name="nis" value="{{ old('nis') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Nama Siswa</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki Laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Tempat Lahir Siswa</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Tanggal Lahir Siswa</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', now()->toDateString()) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Alamat Siswa</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">No Telepon</label>
                    <input type="number" name="telepon" value="{{ old('telepon') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Kelas</label>
                    <select name="kelas_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
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
            </div>

            {{-- DATA ORANG TUA --}}
            <h3 class="text-lg font-semibold mt-6">Data Orang Tua</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-1">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">No Telepon Ayah</label>
                    <input type="text" name="telepon_ayah" value="{{ old('telepon_ayah') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">No Telepon Ibu</label>
                    <input type="text" name="telepon_ibu" value="{{ old('telepon_ibu') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
            </div>

            {{-- BIAYA --}}
            <h3 class="text-lg font-semibold mt-6">Data Pembayaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-1">Total Biaya Pendaftaran</label>
                    <input type="text" value="Rp {{ number_format($biayaTotal, 0, ',', '.') }}" readonly
                        class="w-full border border-gray-300 bg-gray-100 rounded-lg px-4 py-2 text-gray-600">
                </div>

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

                {{-- Total Setelah Potongan --}}
                <div>
                    <label class="block text-gray-700 mb-1">Total yang Harus Dibayar</label>
                    <input type="text" id="total_harus_dibayar" readonly
                        class="w-full border border-gray-300 bg-gray-100 rounded-lg px-4 py-2 text-gray-700">
                </div>

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

                <div>
                    <label class="block text-gray-700 mb-1">Jumlah Dibayar</label>
                    <input type="number" step="0.01" name="total_dibayar" value="{{ old('total_dibayar') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex space-x-2 pt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('transaksi_pendaftaran.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const biayaTotal = {{ $biayaTotal }};
    const potonganSelect = document.getElementById('potongan_id');
    const jenisPembayaran = document.getElementById('jenis_pembayaran');
    const totalDibayarInput = document.querySelector('input[name="total_dibayar"]');
    const totalHarusDibayar = document.getElementById('total_harus_dibayar');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function hitungTotal() {
        let potonganPersen = 0;
        if (potonganSelect.value) {
            potonganPersen = parseFloat(potonganSelect.selectedOptions[0].dataset.persentase) || 0;
        }
        const totalSetelahPotongan = biayaTotal - (biayaTotal * potonganPersen / 100);
        totalHarusDibayar.value = formatRupiah(totalSetelahPotongan.toFixed(0));

        if (jenisPembayaran.value === 'Lunas') {
            totalDibayarInput.value = totalSetelahPotongan.toFixed(0);
            totalDibayarInput.readOnly = true;
        } else {
            totalDibayarInput.readOnly = false;
        }
    }

    potonganSelect.addEventListener('change', hitungTotal);
    jenisPembayaran.addEventListener('change', hitungTotal);

    // Jalankan saat halaman pertama kali dibuka
    hitungTotal();
});
</script>
@endsection

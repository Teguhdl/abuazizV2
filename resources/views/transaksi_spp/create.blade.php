@extends('layouts.app')

@section('title', 'Tambah Transaksi SPP')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Transaksi SPP</h2>

        <form action="{{ route('transaksi-spp.store') }}" method="POST" id="formSPP">
            @csrf

            {{-- Pilih Siswa --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun Ajaran --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Tahun Ajaran</label>
                <input type="text" name="tahun" class="w-full border rounded p-2 bg-gray-100" 
                    value="{{ $pengaturan->tahun_ajaran }}" readonly>
            </div>

            {{-- Nominal SPP --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nominal per Bulan</label>
                <input type="text" id="nominal_spp" class="w-full border rounded p-2 bg-gray-100" 
                    value="Rp {{ number_format($pengaturan->nominal, 0, ',', '.') }}" readonly>
            </div>

            {{-- Bulan Pembayaran --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">Pilih Bulan yang Dibayar</label>
                <div class="grid grid-cols-3 md:grid-cols-4 gap-2" id="bulan-container">
                    @php
                        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp

                    @foreach ($bulanList as $bulan)
                        <label class="flex items-center space-x-2 border p-2 rounded transition hover:bg-blue-50 cursor-pointer bulan-item">
                            <input type="checkbox" name="bulan[]" value="{{ $bulan }}" class="bulan-checkbox">
                            <span>{{ $bulan }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Total Bayar --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Total Bayar</label>
                <input type="text" id="total_bayar" class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full border rounded p-2">
                    <option value="tunai">Tunai</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>

            {{-- Keterangan --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JS untuk total dan disable bulan --}}
<script>
    const nominal = {{ $pengaturan->nominal }};
    const bulanTerbayar = @json($bulanTerbayar); // format: { siswa_id: [{bulan: "Januari", tahun: "2025"}, ...] }

    const siswaSelect = document.getElementById('siswa_id');
    const totalBayar = document.getElementById('total_bayar');
    const bulanCheckboxes = document.querySelectorAll('.bulan-checkbox');
    const bulanItems = document.querySelectorAll('.bulan-item');

    // Fungsi reset bulan
    function resetBulan() {
        bulanCheckboxes.forEach(chk => {
            chk.disabled = false;
            chk.checked = false;
        });
        bulanItems.forEach(div => {
            div.classList.remove('bg-gray-200', 'opacity-60');
        });
        totalBayar.value = '';
    }

    // Saat siswa berubah
    siswaSelect.addEventListener('change', () => {
        resetBulan();
        const siswaId = siswaSelect.value;
        if (!siswaId || !bulanTerbayar[siswaId]) return;

        // disable bulan yang sudah dibayar
        bulanTerbayar[siswaId].forEach(item => {
            bulanCheckboxes.forEach(chk => {
                if (chk.value === item.bulan && item.tahun == {{ $pengaturan->tahun_ajaran }}) {
                    chk.disabled = true;
                    chk.parentElement.classList.add('bg-gray-200', 'opacity-60');
                }
            });
        });
    });

    // Hitung total otomatis
    bulanCheckboxes.forEach(chk => {
        chk.addEventListener('change', () => {
            const count = document.querySelectorAll('.bulan-checkbox:checked:not(:disabled)').length;
            const total = count * nominal;
            totalBayar.value = total ? 'Rp ' + total.toLocaleString('id-ID') : '';
        });
    });
</script>
@endsection

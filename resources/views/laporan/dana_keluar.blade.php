@extends('layouts.app')

@section('title', 'Laporan Pengeluaran Operasional ')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Laporan Pengeluaran Operasional </h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        {{-- Header Laporan --}}
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold">Laporan Pengeluaran Operasional</h2>
            <h1 class="text-2xl font-bold">SD Abu Aziz</h1>
            @php
            $periode = '';
            if ($from && $to) {
            $periode = \Carbon\Carbon::parse($from)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($to)->format('d M Y');
            } elseif ($from) {
            $periode = 'Mulai ' . \Carbon\Carbon::parse($from)->format('d M Y');
            } elseif ($to) {
            $periode = 'Sampai ' . \Carbon\Carbon::parse($to)->format('d M Y');
            } else {
            $periode = now()->translatedFormat('F Y');
            }
            @endphp
            <h3 class="text-lg">Periode {{ $periode }}</h3>
        </div>
        {{-- Filter Tanggal + Button Print di samping --}}
        <form method="GET" class="flex items-end gap-4 mb-4">
            <div>
                <label for="from" class="block text-sm font-medium">Dari</label>
                <input type="date" name="from" id="from" value="{{ request('from') }}" class="border rounded px-2 py-1">
            </div>
            <div>
                <label for="to" class="block text-sm font-medium">Sampai</label>
                <input type="date" name="to" id="to" value="{{ request('to') }}" class="border rounded px-2 py-1">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                <a href="{{ route('pengeluaran.print', request()->query()) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Print Laporan Pengeluaran</a>
            </div>
        </form>

        {{-- Tabel Laporan --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Nama Akun</th>
                        <th class="border p-2">Keterangan</th>
                        <th class="border p-2 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                    <tr>
                        <td class="border p-2">{{ $index + 1 }}</td>
                        <td class="border p-2">{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d/m/Y') }}</td>
                        <td class="border p-2">{{ $item->akun->nama_akun ?? '-' }}</td>
                        <td class="border p-2">{{ $item->keterangan }}</td>
                        <td class="border p-2 text-right">{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-3 text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50 font-semibold">
                    <tr>
                        <td colspan="4" class="border p-2 text-right">Total</td>
                        <td class="border p-2 text-right">{{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
@endsection
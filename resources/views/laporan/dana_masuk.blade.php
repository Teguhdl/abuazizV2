@extends('layouts.app')

@php
    $role = strtolower(auth()->user()->role ?? '');
    $jenisPendapatan = str_contains($role, 'yayasan') ? 'yayasan' : 'sekolah';
    $labelJenis = $jenisPendapatan === 'yayasan' ? 'Dana Masuk Yayasan' : 'Dana Masuk Sekolah';
@endphp

@section('title', 'Laporan ' . $labelJenis)
@section('breadcrumb')
<h1 class="text-xl font-semibold">Laporan {{ $labelJenis }}</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        {{-- Header Laporan --}}
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold">{{ $labelJenis }}</h2>
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
                <a href="{{ route('pendapatan.print', request()->query()) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Print Laporan Pendapatan</a>
            </div>
        </form>

        {{-- Tabel Data --}}
        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Kode</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Keterangan</th>
                    <th class="border px-4 py-2 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @forelse ($data as $item)
                    @php $total += $item->nominal; @endphp
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $item->kode }}</td>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_pendapatan)->format('d-m-Y') }}</td>
                        <td class="border px-4 py-2">{{ $item->nama }}</td>
                        <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                        <td class="border px-4 py-2 text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Belum ada data</td>
                    </tr>
                @endforelse

                {{-- Total --}}
                <tr class="font-bold bg-gray-50">
                    <td colspan="5" class="border px-4 py-2 text-center">TOTAL</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

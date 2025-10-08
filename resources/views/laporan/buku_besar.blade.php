@extends('layouts.app')

@section('title', 'Buku Besar')
@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        {{-- Filter Akun & Tanggal --}}
        <form method="GET" class="flex gap-4 mb-4 flex-wrap items-end">
            <div>
                <label for="akun" class="block text-sm font-medium">Akun</label>
                <select name="akun" id="akun" class="border rounded px-2 py-1">
                    <option value="">-- Pilih Akun --</option>
                    @foreach($akun as $a)
                    <option value="{{ $a->no_akun }}" @if(request('akun')==$a->no_akun) selected @endif>{{ $a->nama_akun }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="from" class="block text-sm font-medium">Dari</label>
                <input type="date" name="from" id="from" value="{{ request('from') }}" class="border rounded px-2 py-1">
            </div>
            <div>
                <label for="to" class="block text-sm font-medium">Sampai</label>
                <input type="date" name="to" id="to" value="{{ request('to') }}" class="border rounded px-2 py-1">
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
            </div>
        </form>
        {{-- Header --}}
        <div class="text-center mt-6 mb-4">
            <h1 class="text-2xl font-bold">SD Abu Aziz</h1>
            <h2 class="text-xl font-semibold">Buku Besar</h2>
            @if(request('from') && request('to'))
            <h3 class="text-lg">Periode {{ \Carbon\Carbon::parse(request('from'))->format('d F Y') }} s.d. {{ \Carbon\Carbon::parse(request('to'))->format('d F Y') }}</h3>
            @endif
        </div>

        {{-- Tabel Buku Besar --}}
        <table class="min-w-full border">
            <thead class="bg-gray-100 text-center">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Nama Akun</th>
                    <th class="border px-4 py-2">Ref</th>
                    <th class="border px-4 py-2">Debit</th>
                    <th class="border px-4 py-2">Kredit</th>
                    <th class="border px-4 py-2">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $saldo = $saldoAwal;
                    $counter = 1;
                @endphp
                <tr class="font-semibold bg-gray-200">
                    <td colspan="4">Saldo Awal {{ $akunTerpilih->nama_akun ?? '' }} - {{ $akunTerpilih->no_akun ?? '' }}</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">Rp {{ number_format($saldo, 2, ',', '.') }}</td>
                </tr>

                @forelse($details as $detail)
                    @php
                        $saldo += $detail->debit - $detail->kredit;
                    @endphp
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $counter++ }}</td>
                        <td class="border px-4 py-2 text-center">{{ \Carbon\Carbon::parse($detail->header->tanggal)->format('d F Y') }}</td>
                        <td class="border px-4 py-2">{{ $detail->akun->nama_akun ?? '' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $detail->akun->no_akun ?? '' }}</td>
                        <td class="border px-4 py-2 text-right">Rp {{ number_format($detail->debit, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2 text-right">Rp {{ number_format($detail->kredit, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2 text-right">Rp {{ number_format($saldo, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
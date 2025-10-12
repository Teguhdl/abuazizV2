@extends('layouts.app')

@section('title', 'Jurnal Umum')
@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">

        {{-- Header Laporan --}}
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold">Jurnal Umum</h2>
            <h1 class="text-2xl font-bold">SD Abu Aziz</h1>
            @php
            $from = request('from') ? \Carbon\Carbon::parse(request('from'))->format('F Y') : now()->format('F Y');
            $to = request('to') ? \Carbon\Carbon::parse(request('to'))->format('F Y') : now()->format('F Y');
            @endphp
            <h3 class="text-lg">Periode {{ $from }} - {{ $to }}</h3>
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
                <a href="{{ route('jurnal.print', request()->query()) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Print Jurnal</a>
            </div>
        </form>


        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">No Jurnal</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">No Akun</th>
                    <th class="border px-4 py-2">Akun</th>
                    <th class="border px-4 py-2">Debit</th>
                    <th class="border px-4 py-2">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalDebit = 0;
                $totalKredit = 0;
                @endphp
                @forelse ($jurnal as $header)
                @foreach ($header->details as $detail)
                @php
                $totalDebit += $detail->debit;
                $totalKredit += $detail->kredit;
                @endphp
                <tr>
                    <td class="border px-4 py-2">{{ $header->nomor_jurnal }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($header->tanggal)->format('d-m-Y') }}</td>
                    <td class="border px-4 py-2 text-center">{{ $detail->coa_id }}</td>
                    <td class="border px-4 py-2">{{ $detail->akun->nama_akun ?? '-' }}</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($detail->debit, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($detail->kredit, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">Belum ada data jurnal</td>
                </tr>
                @endforelse
                {{-- Total --}}
                <tr class="font-bold bg-gray-50">
                    <td colspan="4" class="border px-4 py-2 text-center">TOTAL</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
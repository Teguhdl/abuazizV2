{{-- resources/views/reports/print-report.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0.5in;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            margin-bottom: 10px;
        }

        h1, h2, h3 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
        }

        td.text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        @media print {
            body {
                margin: 0.5in;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assets/logonew.png') }}" alt="Logo">
        <h2>{{ $title }}</h2>
        <h1>SD Abu Aziz</h1>
        @if(isset($periode))
            <h3>Periode {{ $periode }}</h3>
        @endif
    </div>

    @if($type === 'jurnal')
        <table>
            <thead>
                <tr>
                    <th>No Jurnal</th>
                    <th>Tanggal</th>
                    <th>No Akun</th>
                    <th>Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDebit = 0;
                    $totalKredit = 0;
                @endphp
                @foreach($data as $header)
                    @foreach($header->details as $detail)
                        @php
                            $totalDebit += $detail->debit;
                            $totalKredit += $detail->kredit;
                        @endphp
                        <tr>
                            <td>{{ $header->nomor_jurnal }}</td>
                            <td>{{ \Carbon\Carbon::parse($header->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $detail->coa_id }}</td>
                            <td>{{ $detail->akun->nama_akun ?? '-' }}</td>
                            <td class="text-right">Rp {{ number_format($detail->debit,0,',','.') }}</td>
                            <td class="text-right">Rp {{ number_format($detail->kredit,0,',','.') }}</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr class="total-row">
                    <td colspan="4" class="text-center">TOTAL</td>
                    <td class="text-right">Rp {{ number_format($totalDebit,0,',','.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalKredit,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>
    @elseif($type === 'pendapatan' || $type === 'pengeluaran')
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($data as $index => $item)
                    @php $total += $item->nominal; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->kode ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->tanggal_pembayaran ?? $item->tanggal_pendapatan)->format('d-m-Y') }}</td>
                        <td>{{ $item->nama ?? ($item->akun->nama_akun ?? '-') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($item->nominal,0,',','.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5" class="text-center">TOTAL</td>
                    <td class="text-right">Rp {{ number_format($total,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <div class="no-print" style="margin-top:20px; text-align:center;">
        <button onclick="window.print();" style="padding:10px 20px; font-size:14px;">Cetak Laporan</button>
    </div>
</body>
</html>

@extends('layouts.app')

@section('title', 'Transaksi Pendaftaran')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Transaksi Pendaftaran</h1>
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Daftar Transaksi Pendaftaran</h2>
        <a href="{{ route('transaksi_pendaftaran.create') }}"
            class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
            Tambah Transaksi
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="tableTransaksi" class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b text-left">No</th>
                    <th class="px-4 py-2 border-b text-left">No Pendaftaran</th>
                    <th class="px-4 py-2 border-b text-left">Nama Siswa</th>
                    <th class="px-4 py-2 border-b text-left">Tanggal Daftar</th>
                    <th class="px-4 py-2 border-b text-left">Biaya Total</th>
                    <th class="px-4 py-2 border-b text-left">Total Dibayar</th>
                    <th class="px-4 py-2 border-b text-left">Sisa Pembayaran</th>
                    <th class="px-4 py-2 border-b text-left">Status</th>
                    <th class="px-4 py-2 border-b text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($data as $item)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $no++ }}</td>
                    <td class="px-4 py-2 border-b">{{ $item->no_pendaftaran }}</td>
                    <td class="px-4 py-2 border-b">{{ $item->siswa->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border-b">{{ $item->tanggal_daftar }}</td>
                    <td class="px-4 py-2 border-b">Rp {{ number_format($item->biaya_total, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border-b">Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border-b">Rp {{ number_format($item->sisa_pembayaran, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border-b">
                        <span
                            class="px-2 py-1 text-xs rounded {{ $item->status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border-b text-center space-x-2">
                        <a href="{{ route('transaksi_pendaftaran.show', $item->id) }}"
                            class="inline-flex items-center bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                            <i data-lucide="info" class="w-4 h-4 mr-1"></i> Detail
                        </a>
                        @if($item->status == 'belum_lunas')
                        <a href="{{ route('transaksi_pendaftaran.bayar', $item->id) }}"
                            class="inline-flex items-center bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                            <i data-lucide="credit-card" class="w-4 h-4 mr-1"></i> Bayar Sisa
                        </a>
                        @endif

                        <!-- <button type="button"
                            class="inline-flex items-center bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 text-sm btn-delete"
                            data-id="{{ $item->id }}">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                        </button>

                        <form id="delete-form-{{ $item->id }}"
                            action="{{ route('transaksi_pendaftaran.destroy', $item->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data transaksi ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection
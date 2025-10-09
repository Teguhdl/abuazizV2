@extends('layouts.app')

@section('title', 'Master Pembayaran Beban')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Data Pembayaran Beban</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Daftar Pembayaran Beban</h2>
            <a href="{{ route('pembayaran_beban.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</a>
        </div>

        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">No Akun</th>
                    <th class="border px-4 py-2">Nama Akun</th>
                    <th class="border px-4 py-2">Tanggal Pembayaran</th>
                    <th class="border px-4 py-2">Nominal</th>
                    <th class="border px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayaran as $item)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $item->no_akun }}</td>
                        <td class="border px-4 py-2">{{ $item->akun->nama_akun ?? '-' }}</td>
                        <td class="border px-4 py-2">
                            {{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d-m-Y') }}
                        </td>
                        <td class="border px-4 py-2">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                        <!-- <td class="border px-4 py-2 text-center">
                            <a href="{{ route('pembayaran_beban.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Edit</a>
                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm" onclick="hapus({{ $item->id }})">Hapus</button>
                        </td> -->
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
<!-- 
<script>
function hapus(id) {
    if (confirm('Yakin ingin menghapus data ini?')) {
        fetch(`/pembayaran_beban/${id}`, {
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        }).then(res => res.json())
          .then(data => { if (data.success) location.reload(); });
    }
}
</script> -->
@endsection

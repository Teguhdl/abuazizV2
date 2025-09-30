@extends('layouts.app')

@section('title', 'Data Kelas')

@section('breadcrumb')
<h1 class="text-xl font-semibold"></h1>
@endsection
@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Daftar Kelas</h2>
        <a href="{{ route('kelas.create') }}"
            class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
            Tambah Kelas
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b">No</th>
                    <th class="px-4 py-2 border-b">Nama Kelas</th>
                    <th class="px-4 py-2 border-b">Tingkat</th>
                    <th class="px-4 py-2 border-b">Sekolah</th>
                    <th class="px-4 py-2 text-center border-b w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php 
                $no = 1;
                @endphp
                @foreach($kelas as $k)
                <tr>
                    <td class="px-4 py-2 border-b text-center">{{ $no++ }}</td>
                    <td class="px-4 py-2 border-b text-center">{{ $k->nama }}</td>
                    <td class="px-4 py-2 border-b text-center">{{ $k->tingkat }}</td>
                    <td class="px-4 py-2 border-b text-center">{{ $k->sekolah->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center space-x-2">
                      <a href="{{ route('kelas.edit', $k->id) }}"
                            class="inline-flex items-center bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600 text-sm">
                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                        </a>

                        <button type="button"
                            class="inline-flex items-center bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 text-sm btn-delete"
                            data-id="{{ $k->id }}">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                        </button>

                        <form id="delete-form-{{ $k->id }}" action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
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
            text: "Data kelas ini akan dihapus permanen!",
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

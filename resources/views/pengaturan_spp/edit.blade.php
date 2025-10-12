@extends('layouts.app')

@section('title', 'Edit Pengaturan SPP')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Edit Pengaturan SPP</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
        <form action="{{ route('pengaturan-spp.update', $pengaturan_spp->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-medium">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="border rounded w-full p-2" value="{{ old('tahun_ajaran', $pengaturan_spp->tahun_ajaran) }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Nominal (Rp)</label>
                <input type="number" name="nominal" class="border rounded w-full p-2" value="{{ old('nominal', $pengaturan_spp->nominal) }}" required>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('pengaturan-spp.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection

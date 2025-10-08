@extends('layouts.app')

@section('title', 'Edit Pembayaran Beban')
@section('breadcrumb')
<h1 class="text-xl font-semibold">Edit Pembayaran Beban</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('pembayaran_beban.update', $pembayaranBeban->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Tanggal Pembayaran</label>
                <input type="date" 
                       name="tanggal_pembayaran" 
                       class="w-full border rounded p-2 @error('tanggal_pembayaran') border-red-500 @enderror"
                       value="{{ old('tanggal_pembayaran', $pembayaranBeban->tanggal_pembayaran) }}" 
                       required>
                @error('tanggal_pembayaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">No Akun</label>
                <select name="no_akun" class="w-full border rounded p-2 @error('no_akun') border-red-500 @enderror" required>
                    <option value="">-- Pilih Akun Beban --</option>
                    @foreach($akun_beban as $akun)
                        <option value="{{ $akun->no_akun }}" 
                                {{ old('no_akun', $pembayaranBeban->no_akun) == $akun->no_akun ? 'selected' : '' }}>
                            {{ $akun->no_akun }} - {{ $akun->nama_akun }}
                        </option>
                    @endforeach
                </select>
                @error('no_akun')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nominal</label>
                <input type="number" 
                       name="nominal" 
                       step="0.01"
                       class="w-full border rounded p-2 @error('nominal') border-red-500 @enderror" 
                       value="{{ old('nominal', $pembayaranBeban->nominal) }}" 
                       required>
                @error('nominal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded p-2">{{ old('keterangan', $pembayaranBeban->keterangan) }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbarui</button>
                <a href="{{ route('pembayaran_beban.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

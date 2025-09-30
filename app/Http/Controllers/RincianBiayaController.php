<?php

namespace App\Http\Controllers;

use App\Models\RincianBiaya;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class RincianBiayaController extends Controller
{
    public function index()
    {
        $rincian = RincianBiaya::with('sekolah')->get();
        return view('rincian_biaya.index', compact('rincian'));
    }

    public function create()
    {
        $sekolah = Sekolah::all();
        return view('rincian_biaya.create', compact('sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|numeric',
            'sekolah_id' => 'required|exists:sekolah,id',
            'transaksi' => 'required|in:pendaftaran,daftar_ulang',
        ]);


        RincianBiaya::create($request->all());
        return redirect()->route('rincian_biaya.index')->with('success', 'Rincian biaya berhasil ditambahkan');
    }

    public function edit(RincianBiaya $rincian_biaya)
    {
        $sekolah = Sekolah::all();
        return view('rincian_biaya.edit', compact('rincian_biaya', 'sekolah'));
    }

    public function update(Request $request, RincianBiaya $rincian_biaya)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|numeric',
            'sekolah_id' => 'required|exists:sekolah,id',
            'transaksi' => 'required|in:pendaftaran,daftar_ulang',
        ]);


        $rincian_biaya->update($request->all());
        return redirect()->route('rincian_biaya.index')->with('success', 'Rincian biaya berhasil diperbarui');
    }

    public function destroy(RincianBiaya $rincian_biaya)
    {
        $rincian_biaya->delete();
        return redirect()->route('rincian_biaya.index')->with('success', 'Rincian biaya berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PotonganBiaya;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class PotonganBiayaController extends Controller
{
    public function index()
    {
        $potongan = PotonganBiaya::with('sekolah')->get();
        return view('potongan_biaya.index', compact('potongan'));
    }

    public function create()
    {
        $sekolah = Sekolah::all();
        return view('potongan_biaya.create', compact('sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|numeric',
            'sekolah_id' => 'required|exists:sekolah,id',
            'transaksi' => 'required|in:pendaftaran,daftar_ulang',
        ]);


        PotonganBiaya::create($request->all());
        return redirect()->route('potongan_biaya.index')->with('success', 'Potongan biaya berhasil ditambahkan');
    }

    public function edit(PotonganBiaya $potongan_biaya)
    {
        $sekolah = Sekolah::all();
        return view('potongan_biaya.edit', compact('potongan_biaya', 'sekolah'));
    }

    public function update(Request $request, PotonganBiaya $potongan_biaya)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|numeric',
            'sekolah_id' => 'required|exists:sekolah,id',
            'transaksi' => 'required|in:pendaftaran,daftar_ulang',
        ]);

        $potongan_biaya->update($request->all());
        return redirect()->route('potongan_biaya.index')->with('success', 'Potongan biaya berhasil diperbarui');
    }

    public function destroy(PotonganBiaya $potongan_biaya)
    {
        $potongan_biaya->delete();
        return redirect()->route('potongan_biaya.index')->with('success', 'Potongan biaya berhasil dihapus');
    }
}

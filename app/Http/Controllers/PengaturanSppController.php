<?php

namespace App\Http\Controllers;

use App\Models\PengaturanSpp;
use Illuminate\Http\Request;

class PengaturanSppController extends Controller
{
    public function index()
    {
        $data = PengaturanSpp::orderBy('tahun_ajaran', 'desc')->get();
        return view('pengaturan_spp.index', compact('data'));
    }

    public function create()
    {
        return view('pengaturan_spp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'nominal' => 'required|numeric|min:0',
        ]);

        PengaturanSpp::create($request->only(['tahun_ajaran', 'nominal']));

        return redirect()->route('pengaturan-spp.index')
            ->with('success', 'Data pengaturan SPP berhasil ditambahkan.');
    }

    public function edit(PengaturanSpp $pengaturan_spp)
    {
        return view('pengaturan_spp.edit', compact('pengaturan_spp'));
    }

    public function update(Request $request, PengaturanSpp $pengaturan_spp)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'nominal' => 'required|numeric|min:0',
        ]);

        $pengaturan_spp->update($request->only(['tahun_ajaran', 'nominal']));

        return redirect()->route('pengaturan-spp.index')
            ->with('success', 'Data pengaturan SPP berhasil diperbarui.');
    }

    public function destroy(PengaturanSpp $pengaturan_spp)
    {
        $pengaturan_spp->delete();
        return redirect()->route('pengaturan-spp.index')
            ->with('success', 'Data pengaturan SPP berhasil dihapus.');
    }
}

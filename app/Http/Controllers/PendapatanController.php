<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendapatanController extends Controller
{
    public function index()
    {
        $data = Pendapatan::orderBy('tanggal_pendapatan', 'desc')->get();
        return view('pendapatan.index', compact('data'));
    }

    public function create()
    {
        return view('pendapatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_pendapatan' => 'required|date',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
        ]);

        Pendapatan::create([
            'kode' => 'PD-' . strtoupper(Str::random(5)),
            'nama' => $request->nama,
            'tanggal_pendapatan' => $request->tanggal_pendapatan,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Pendapatan::findOrFail($id);
        return view('pendapatan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_pendapatan' => 'required|date',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
        ]);

        $data = Pendapatan::findOrFail($id);
        $data->update([
            'nama' => $request->nama,
            'tanggal_pendapatan' => $request->tanggal_pendapatan,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pendapatan::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

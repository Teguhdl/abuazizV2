<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas.sekolah')->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::with('sekolah')->get();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Siswa::create($request->all());
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::with('sekolah')->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:255',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:20',
            'nama_ayah'      => 'nullable|string|max:255',
            'telepon_ayah'   => 'nullable|string|max:20',
            'nama_ibu'       => 'nullable|string|max:255',
            'telepon_ibu'    => 'nullable|string|max:20',
            'kelas_id'       => 'required|exists:kelas,id',
            'status'         => 'nullable|in:aktif,nonaktif',
        ]);

        $siswa->update($request->only([
            'nama',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'telepon',
            'nama_ayah',
            'telepon_ayah',
            'nama_ibu',
            'telepon_ibu',
            'kelas_id',
            'status',
        ]));

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}

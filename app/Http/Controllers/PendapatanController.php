<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use App\Models\JurnalHeader;
use App\Models\JurnalDetail;
use App\Models\Akun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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

        DB::transaction(function () use ($request) {
            // Simpan pendapatan
            $pendapatan = Pendapatan::create([
                'kode' => 'PD-' . strtoupper(Str::random(5)),
                'nama' => $request->nama,
                'tanggal_pendapatan' => $request->tanggal_pendapatan,
                'keterangan' => $request->keterangan,
                'nominal' => $request->nominal,
            ]);

            // ----------------------------
            // Buat Jurnal Umum
            // ----------------------------
            $header = JurnalHeader::create([
                'nomor_jurnal' => 'PJ-' . date('YmdHis'), // PJ = Pendapatan
                'tanggal' => $pendapatan->tanggal_pendapatan,
                'keterangan' => 'Pendapatan: ' . $pendapatan->nama,
            ]);

            // Debit = Kas/Bank
            $akunKas = Akun::where('nama_akun', 'Kas')->first();
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunKas->no_akun,
                'debit' => $pendapatan->nominal,
                'kredit' => 0,
                'keterangan' => 'Penerimaan pendapatan: ' . $pendapatan->nama,
            ]);

            // Kredit = Pendapatan (akun pendapatan umum)
            $akunPendapatan = Akun::where('nama_akun', 'Pendapatan Lain-Lain')->first();
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunPendapatan->no_akun,
                'debit' => 0,
                'kredit' => $pendapatan->nominal,
                'keterangan' => 'Pendapatan: ' . $pendapatan->nama,
            ]);
        });

        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan berhasil ditambahkan dan dijurnal.');
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

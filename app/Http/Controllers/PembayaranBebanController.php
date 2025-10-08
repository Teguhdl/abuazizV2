<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembayaranBeban;
use App\Models\Akun;
use App\Models\JurnalHeader;
use App\Models\JurnalDetail;
use Illuminate\Support\Facades\DB;

class PembayaranBebanController extends Controller
{
    public function index()
    {
        // ambil semua pembayaran beserta data akun
        $pembayaran = PembayaranBeban::with('akun')->get();
        return view('pembayaran_beban.index', compact('pembayaran'));
    }

    public function create()
    {
        // ambil semua akun jenis 'beban'
        $akun_beban = Akun::where('jenis_akun', 'beban')->get();
        return view('pembayaran_beban.create', compact('akun_beban'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'no_akun' => 'required|exists:akun,no_akun', // akun beban
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan pembayaran beban
            $pembayaran = PembayaranBeban::create($request->all());

            // ----------------------------
            // Buat Jurnal Umum
            // ----------------------------
            $header = JurnalHeader::create([
                'nomor_jurnal' => 'PB-' . date('YmdHis'), // PB = Pembayaran Beban
                'tanggal' => $pembayaran->tanggal_pembayaran,
                'keterangan' => $pembayaran->keterangan ?? 'Pembayaran beban',
            ]);

            // Debit = Beban (akun yang dipilih)
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $request->no_akun,
                'debit' => $pembayaran->nominal,
                'kredit' => 0,
                'keterangan' => $pembayaran->keterangan ?? 'Pembayaran beban',
            ]);

            // Kredit = Kas (akun default)
            $akunKas = Akun::where('nama_akun', 'Kas')->first();

            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunKas->no_akun,
                'debit' => 0,
                'kredit' => $pembayaran->nominal,
                'keterangan' => $pembayaran->keterangan ?? 'Pembayaran beban',
            ]);
        });

        return redirect()->route('pembayaran_beban.index')->with('success', 'Pembayaran beban berhasil ditambahkan dan dijurnal.');
    }


    public function edit(PembayaranBeban $pembayaranBeban)
    {
        $akun_beban = Akun::where('jenis_akun', 'beban')->get();
        return view('pembayaran_beban.edit', compact('pembayaranBeban', 'akun_beban'));
    }

    public function update(Request $request, PembayaranBeban $pembayaranBeban)
    {
        $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'no_akun' => 'required|exists:akun,no_akun',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaranBeban->update($request->all());

        return redirect()->route('pembayaran_beban.index')->with('success', 'Pembayaran beban berhasil diupdate.');
    }

    public function destroy(PembayaranBeban $pembayaranBeban)
    {
        $pembayaranBeban->delete();
        return redirect()->route('pembayaran_beban.index')->with('success', 'Pembayaran beban berhasil dihapus.');
    }
}

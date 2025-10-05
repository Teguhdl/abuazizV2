<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\PotonganBiaya;
use App\Models\RincianBiaya;
use App\Models\TransaksiDaftarUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiDaftarUlangController extends Controller
{
    public function index()
    {
        $data = TransaksiDaftarUlang::with('siswa')->latest()->get();
        return view('transaksi_daftar_ulang.index', compact('data'));
    }

    public function create()
    {
        $siswa = Siswa::orderBy('nama')->get();
        $potongan = PotonganBiaya::all();
        $biayaTotal = RincianBiaya::where('transaksi', 'daftar_ulang')->sum('jumlah');

        return view('transaksi_daftar_ulang.create', compact('siswa', 'potongan', 'biayaTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal_daftar' => 'required|date',
            'metode_pembayaran' => 'required|string|in:Tunai,Transfer',
            'jenis_pembayaran' => 'required|string|in:Lunas,Kredit',
            'potongan_id' => 'nullable|exists:potongan_biaya,id',
            'total_dibayar' => 'required|numeric|min:0',
        ]);

        $biayaTotal = RincianBiaya::where('transaksi', 'daftar_ulang')->sum('jumlah');

        $potonganPersen = $request->potongan_id
            ? (PotonganBiaya::find($request->potongan_id)->jumlah ?? 0)
            : 0;

        $finalTotal = $biayaTotal - ($biayaTotal * $potonganPersen / 100);

        $totalDibayar = $request->jenis_pembayaran === 'Lunas'
            ? $finalTotal
            : $request->total_dibayar;

        TransaksiDaftarUlang::create([
            'siswa_id' => $request->siswa_id,
            'no_daftar_ulang' => 'DU-' . strtoupper(Str::random(6)),
            'tanggal_daftar' => $request->tanggal_daftar,
            'biaya_total' => $finalTotal,
            'potongan_id' => $request->potongan_id,
            'total_dibayar' => $totalDibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'status' => $totalDibayar >= $finalTotal ? 'lunas' : 'belum_lunas',
        ]);

        return redirect()->route('transaksi_daftar_ulang.index')->with('success', 'Daftar ulang berhasil disimpan.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\JurnalDetail;
use Illuminate\Support\Facades\DB;
class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $akun = Akun::all();

        $akunTerpilih = null;
        $details = collect();
        $saldoAwal = 0;

        if ($request->akun) {
            $akunTerpilih = Akun::where('no_akun', $request->akun)->first();

            // Hitung saldo awal sebelum tanggal 'from'
            if ($request->from) {
                $saldoAwal = JurnalDetail::where('coa_id', $request->akun)
                    ->whereHas('header', function($q) use ($request) {
                        $q->where('tanggal', '<', $request->from);
                    })
                    ->sum(DB::raw('debit - kredit'));
            }

            // Ambil detail jurnal sesuai filter
            $details = JurnalDetail::with('header', 'akun')
                ->where('coa_id', $request->akun)
                ->get()
                ->filter(function($item) use ($request) {
                    if ($request->from && $item->header->tanggal < $request->from) return false;
                    if ($request->to && $item->header->tanggal > $request->to) return false;
                    return true;
                })
                ->sortBy('header.tanggal')
                ->values();
        }

        return view('laporan.buku_besar', compact('akun', 'akunTerpilih', 'details', 'saldoAwal'));
    }
}

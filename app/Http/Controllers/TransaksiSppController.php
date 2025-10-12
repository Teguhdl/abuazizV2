<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\PengaturanSpp;
use App\Models\TransaksiSpp;
use App\Models\TransaksiSppDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JurnalHeader;
use App\Models\JurnalDetail;
use App\Models\Akun;

class TransaksiSppController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiSpp::with('siswa')->latest()->get();
        return view('transaksi_spp.index', compact('transaksi'));
    }

    public function create()
    {
        $siswa = Siswa::where('status', 'aktif')->get();
        $pengaturan = PengaturanSpp::latest()->first();

        // Ambil data bulan yang sudah dibayar (grup per siswa)
        $bulanTerbayar = TransaksiSppDetail::select('bulan', 'tahun', 'transaksi_spp_id')
            ->with('transaksi')
            ->get()
            ->groupBy(fn($item) => $item->transaksi->siswa_id);

        return view('transaksi_spp.create', compact('siswa', 'pengaturan', 'bulanTerbayar'));
    }


      public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'bulan' => 'required|array',
            'bulan.*' => 'required|string',
            'tahun' => 'required|numeric',
            'metode_pembayaran' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $pengaturan = PengaturanSpp::latest()->firstOrFail();
        $total = count($request->bulan) * $pengaturan->nominal;

        DB::transaction(function () use ($request, $pengaturan, $total) {

            // ----------------------------
            // 1️⃣ Simpan Transaksi SPP
            // ----------------------------
            $transaksi = TransaksiSpp::create([
                'siswa_id' => $request->siswa_id,
                'nomor_transaksi' => 'SPP-' . strtoupper(Str::random(6)),
                'tanggal_bayar' => Carbon::now(),
                'total_bayar' => $total,
                'metode_pembayaran' => $request->metode_pembayaran ?? 'tunai',
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->bulan as $bulan) {
                TransaksiSppDetail::create([
                    'transaksi_spp_id' => $transaksi->id,
                    'bulan' => $bulan,
                    'tahun' => $request->tahun,
                    'nominal' => $pengaturan->nominal,
                ]);
            }

            // ----------------------------
            // 2️⃣ Buat Jurnal Umum
            // ----------------------------
            $header = JurnalHeader::create([
                'nomor_jurnal' => 'JSPP-' . date('YmdHis'),
                'tanggal' => $transaksi->tanggal_bayar,
                'keterangan' => 'Pembayaran SPP siswa ID: ' . $transaksi->siswa_id,
            ]);

            // Ambil akun terkait
            $akunKas = Akun::where('nama_akun', 'Kas')->first();
            $akunPendapatanSpp = Akun::where('nama_akun', 'Pendapatan SPP')->first();

            if (!$akunKas || !$akunPendapatanSpp) {
                throw new \Exception('Akun "Kas" atau "Pendapatan SPP" belum terdaftar di tabel akun.');
            }

            // ----------------------------
            // 3️⃣ Buat Jurnal Detail
            // ----------------------------
            // Debit Kas (uang masuk)
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunKas->no_akun,
                'debit' => $total,
                'kredit' => 0,
                'keterangan' => 'Pembayaran SPP siswa ID: ' . $transaksi->siswa_id,
            ]);

            // Kredit Pendapatan SPP
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunPendapatanSpp->no_akun,
                'debit' => 0,
                'kredit' => $total,
                'keterangan' => 'Pendapatan SPP siswa ID: ' . $transaksi->siswa_id,
            ]);
        });

        return redirect()->route('transaksi-spp.index')->with('success', 'Transaksi SPP berhasil disimpan dan dijurnal.');
    }
}

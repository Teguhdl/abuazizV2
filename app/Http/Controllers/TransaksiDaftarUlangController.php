<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\PotonganBiaya;
use App\Models\RincianBiaya;
use App\Models\TransaksiDaftarUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\JurnalHeader;
use App\Models\JurnalDetail;
use App\Models\Akun;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        DB::transaction(function () use ($request, $finalTotal, $totalDibayar, $biayaTotal) {
            // Simpan transaksi daftar ulang
            $transaksi = TransaksiDaftarUlang::create([
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

            // ----------------------------
            // Buat Jurnal Umum
            // ----------------------------
            $header = JurnalHeader::create([
                'nomor_jurnal' => 'DJ-' . date('YmdHis'),
                'tanggal' => $transaksi->tanggal_daftar,
                'keterangan' => 'Transaksi daftar ulang siswa ID: ' . $transaksi->siswa_id,
            ]);

            $akunKas = Akun::where('nama_akun', 'Kas')->first();
            $akunPendapatan = Akun::where('nama_akun', 'Pendapatan Daftar Ulang')->first();
            $akunDiskon = $request->potongan_id
                ? Akun::where('nama_akun', 'Diskon Daftar Ulang')->first()
                : null;
            $akunPiutang = Akun::where('nama_akun', 'Piutang Daftar Ulang')->first();

            // === Pembayaran Lunas ===
            if ($request->jenis_pembayaran === 'Lunas') {
                // Debit Kas
                JurnalDetail::create([
                    'jurnal_header_id' => $header->id,
                    'coa_id' => $akunKas->no_akun,
                    'debit' => $totalDibayar,
                    'kredit' => 0,
                    'keterangan' => 'Pembayaran daftar ulang siswa ID: ' . $transaksi->siswa_id,
                ]);

                // Jika ada diskon
                if ($akunDiskon) {
                    $jumlahDiskon = $biayaTotal - $finalTotal;
                    JurnalDetail::create([
                        'jurnal_header_id' => $header->id,
                        'coa_id' => $akunDiskon->no_akun,
                        'debit' => $jumlahDiskon,
                        'kredit' => 0,
                        'keterangan' => 'Diskon daftar ulang siswa ID: ' . $transaksi->siswa_id,
                    ]);
                }

                // Kredit Pendapatan
                JurnalDetail::create([
                    'jurnal_header_id' => $header->id,
                    'coa_id' => $akunPendapatan->no_akun,
                    'debit' => 0,
                    'kredit' => $finalTotal,
                    'keterangan' => 'Pendapatan daftar ulang siswa ID: ' . $transaksi->siswa_id,
                ]);
            }

            // === Pembayaran Kredit ===
            else {
                $sisaPiutang = $finalTotal - $totalDibayar;

                // Debit Kas (yang dibayar)
                if ($totalDibayar > 0) {
                    JurnalDetail::create([
                        'jurnal_header_id' => $header->id,
                        'coa_id' => $akunKas->no_akun,
                        'debit' => $totalDibayar,
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran awal daftar ulang siswa ID: ' . $transaksi->siswa_id,
                    ]);
                }

                // Debit Piutang (yang belum dibayar)
                if ($sisaPiutang > 0) {
                    JurnalDetail::create([
                        'jurnal_header_id' => $header->id,
                        'coa_id' => $akunPiutang->no_akun,
                        'debit' => $sisaPiutang,
                        'kredit' => 0,
                        'keterangan' => 'Piutang daftar ulang siswa ID: ' . $transaksi->siswa_id,
                    ]);
                }

                // Kredit Pendapatan (total biaya setelah potongan)
                JurnalDetail::create([
                    'jurnal_header_id' => $header->id,
                    'coa_id' => $akunPendapatan->no_akun,
                    'debit' => 0,
                    'kredit' => $finalTotal,
                    'keterangan' => 'Pendapatan daftar ulang siswa ID: ' . $transaksi->siswa_id,
                ]);
            }
        });

        return redirect()->route('transaksi_daftar_ulang.index')->with('success', 'Daftar ulang berhasil disimpan dan dijurnal.');
    }

    public function show($id)
    {
        $data = TransaksiDaftarUlang::with(['siswa.kelas', 'potongan'])->findOrFail($id);

        return view('transaksi_daftar_ulang.show', compact('data'));
    }

    public function bayar($id)
    {
        $data = TransaksiDaftarUlang::with('siswa')->findOrFail($id);
        if ($data->status === 'lunas') {
            return redirect()->route('transaksi_daftar_ulang.show', $id)->with('info', 'Transaksi sudah lunas.');
        }

        // Hitung sisa pembayaran
        $data->sisa_pembayaran = $data->biaya_total - $data->total_dibayar;

        return view('transaksi_daftar_ulang.bayar', compact('data'));
    }

    public function bayarStore(Request $request, $id)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:Tunai,Transfer',
        ]);

        $transaksi = TransaksiDaftarUlang::findOrFail($id);

        DB::transaction(function () use ($request, $transaksi) {
            $sisa = $transaksi->biaya_total - $transaksi->total_dibayar;
            $bayar = min($request->jumlah_bayar, $sisa);

            // Update total dibayar & status
            $transaksi->total_dibayar += $bayar;
            if ($transaksi->total_dibayar >= $transaksi->biaya_total) {
                $transaksi->status = 'lunas';
            }
            $transaksi->save();

            // ----------------------------
            // Buat Jurnal Pelunasan Kredit
            // ----------------------------
            $header = JurnalHeader::create([
                'nomor_jurnal' => 'JD-' . date('YmdHis'),
                'tanggal' => Carbon::now(),
                'keterangan' => 'Pelunasan daftar ulang siswa: ' . $transaksi->siswa->nama,
            ]);

            $akunKas = Akun::where('nama_akun', 'Kas')->first();
            $akunPiutang = Akun::where('nama_akun', 'Piutang Daftar Ulang')->first();

            // Debit: Kas (uang masuk)
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunKas->no_akun,
                'debit' => $bayar,
                'kredit' => 0,
                'keterangan' => 'Pelunasan daftar ulang siswa: ' . $transaksi->siswa->nama,
            ]);

            // Kredit: Piutang (berkurang)
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunPiutang->no_akun,
                'debit' => 0,
                'kredit' => $bayar,
                'keterangan' => 'Pelunasan piutang daftar ulang siswa: ' . $transaksi->siswa->nama,
            ]);
        });

        return redirect()->route('transaksi_daftar_ulang.show', $id)
            ->with('success', 'Pelunasan berhasil disimpan dan dijurnal.');
    }
}

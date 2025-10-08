<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Akun;
use App\Models\Siswa;
use App\Models\RincianBiaya;
use App\Models\PotonganBiaya;
use App\Models\TransaksiPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\JurnalHeader;
use App\Models\JurnalDetail;
use Illuminate\Support\Facades\DB;

class TransaksiPendaftaranController extends Controller
{
    public function index()
    {
        $data = TransaksiPendaftaran::with('siswa')->get();
        return view('transaksi_pendaftaran.index', compact('data'));
    }

    public function create()
    {
        $biayaTotal = RincianBiaya::where('transaksi', 'pendaftaran')->sum('jumlah');
        $potongan = PotonganBiaya::where('transaksi', 'pendaftaran')->get();
        $kelas = Kelas::all();

        return view('transaksi_pendaftaran.create', compact('biayaTotal', 'potongan', 'kelas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nis' => 'required|string|max:50|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'nama_ayah' => 'required|string|max:255',
            'telepon_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'telepon_ibu' => 'required|string|max:20',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_daftar' => 'required|date',
            'metode_pembayaran' => 'required|string|in:Tunai,Transfer',
            'potongan_id' => 'nullable|exists:potongan_biaya,id',
            'total_dibayar' => 'required|numeric|min:0',
        ]);

        // Hitung biaya final
        $biayaTotal = RincianBiaya::where('transaksi', 'pendaftaran')->sum('jumlah');
        $potonganPersen = $request->potongan_id
            ? (PotonganBiaya::find($request->potongan_id)->jumlah ?? 0)
            : 0;
        $finalTotal = $biayaTotal - ($biayaTotal * $potonganPersen / 100);
        DB::transaction(function () use ($request, $finalTotal, $biayaTotal) {
            // Simpan data siswa
            $siswa = Siswa::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'nama_ayah' => $request->nama_ayah,
                'telepon_ayah' => $request->telepon_ayah,
                'nama_ibu' => $request->nama_ibu,
                'telepon_ibu' => $request->telepon_ibu,
                'kelas_id' => $request->kelas_id,
            ]);

            // Simpan transaksi pendaftaran
            $transaksi = TransaksiPendaftaran::create([
                'siswa_id' => $siswa->id,
                'no_pendaftaran' => 'REG-' . strtoupper(Str::random(6)),
                'tanggal_daftar' => $request->tanggal_daftar,
                'biaya_total' => $finalTotal,
                'potongan_id' => $request->potongan_id,
                'total_dibayar' => $request->total_dibayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->total_dibayar >= $finalTotal ? 'lunas' : 'belum_lunas',
            ]);

            // ----------------------------
            // Buat Jurnal Umum
            // ----------------------------
            $header = JurnalHeader::create([
                'nomor_jurnal' => 'JP-' . date('YmdHis'),
                'tanggal' => $transaksi->tanggal_daftar,
                'keterangan' => 'Transaksi pendaftaran siswa: ' . $siswa->nama,
            ]);

            $akunKas = Akun::where('nama_akun', 'Kas')->first();
            $akunPendapatan = Akun::where('nama_akun', 'Pendapatan Pendaftaran')->first();
            $akunDiskon = $request->potongan_id
                ? Akun::where('nama_akun', 'Diskon Pendaftaran')->first()
                : null;

            // Debit: Kas = uang yang dibayarkan
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunKas->no_akun,
                'debit' => $transaksi->total_dibayar,
                'kredit' => 0,
                'keterangan' => 'Pembayaran pendaftaran siswa: ' . $siswa->nama,
            ]);

            // Debit: Diskon Pendaftaran = selisih antara total biaya dan yang dibayar
            if ($akunDiskon) {
                $jumlahDiskon = $biayaTotal - $transaksi->total_dibayar;

                JurnalDetail::create([
                    'jurnal_header_id' => $header->id,
                    'coa_id' => $akunDiskon->no_akun,
                    'debit' => $jumlahDiskon,
                    'kredit' => 0,
                    'keterangan' => 'Diskon pendaftaran siswa: ' . $siswa->nama,
                ]);
            }

            // Kredit: Pendapatan Pendaftaran = total biaya asli
            JurnalDetail::create([
                'jurnal_header_id' => $header->id,
                'coa_id' => $akunPendapatan->no_akun,
                'debit' => 0,
                'kredit' => $biayaTotal,
                'keterangan' => 'Pendapatan pendaftaran siswa: ' . $siswa->nama,
            ]);
        });

        return redirect()->route('transaksi_pendaftaran.index')->with('success', 'Pendaftaran berhasil disimpan dan dijurnal.');
    }


    public function show($id)
    {
        $data = TransaksiPendaftaran::with(['siswa.kelas', 'potongan'])
            ->findOrFail($id);

        return view('transaksi_pendaftaran.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = TransaksiPendaftaran::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JurnalHeader;
use App\Models\JurnalDetail;
use App\Models\Akun;
use Illuminate\Support\Facades\DB;

class JurnalUmumController extends Controller
{
    // Menampilkan daftar jurnal
    public function index(Request $request)
    {
        $query = JurnalHeader::with('details.akun');

        if ($request->from) $query->whereDate('tanggal', '>=', $request->from);
        if ($request->to) $query->whereDate('tanggal', '<=', $request->to);

        $jurnal = $query->orderBy('tanggal', 'desc')->get();

        return view('laporan.jurnal', compact('jurnal'));
    }


    // Form tambah jurnal
    public function create()
    {
        $akun = Akun::all(); // pilih akun untuk detail
        return view('jurnal.create', compact('akun'));
    }

    // Simpan jurnal baru
    public function store(Request $request)
    {
        $request->validate([
            'nomor_jurnal' => 'required|unique:jurnal_header,nomor_jurnal',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'detail' => 'required|array|min:2',
            'detail.*.coa_id' => 'required|exists:akun,no_akun',
            'detail.*.debit' => 'nullable|numeric',
            'detail.*.kredit' => 'nullable|numeric',
        ]);

        $totalDebit = array_sum(array_column($request->detail, 'debit'));
        $totalKredit = array_sum(array_column($request->detail, 'kredit'));

        if ($totalDebit != $totalKredit) {
            return back()->withInput()->withErrors(['detail' => 'Total debit harus sama dengan total kredit']);
        }

        DB::transaction(function () use ($request) {
            $header = JurnalHeader::create([
                'nomor_jurnal' => $request->nomor_jurnal,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->detail as $item) {
                JurnalDetail::create([
                    'jurnal_header_id' => $header->id,
                    'coa_id' => $item['coa_id'],
                    'debit' => $item['debit'] ?? 0,
                    'kredit' => $item['kredit'] ?? 0,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }
        });

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    // Form edit jurnal
    public function edit(JurnalHeader $jurnal)
    {
        $akun = Akun::all();
        $jurnal->load('detail');
        return view('jurnal.edit', compact('jurnal', 'akun'));
    }

    // Update jurnal
    public function update(Request $request, JurnalHeader $jurnal)
    {
        $request->validate([
            'nomor_jurnal' => 'required|unique:jurnal_header,nomor_jurnal,' . $jurnal->id,
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'detail' => 'required|array|min:2',
            'detail.*.coa_id' => 'required|exists:akun,no_akun',
            'detail.*.debit' => 'nullable|numeric',
            'detail.*.kredit' => 'nullable|numeric',
        ]);

        $totalDebit = array_sum(array_column($request->detail, 'debit'));
        $totalKredit = array_sum(array_column($request->detail, 'kredit'));

        if ($totalDebit != $totalKredit) {
            return back()->withInput()->withErrors(['detail' => 'Total debit harus sama dengan total kredit']);
        }

        DB::transaction(function () use ($request, $jurnal) {
            $jurnal->update([
                'nomor_jurnal' => $request->nomor_jurnal,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            // Hapus detail lama
            $jurnal->detail()->delete();

            // Simpan detail baru
            foreach ($request->detail as $item) {
                JurnalDetail::create([
                    'jurnal_header_id' => $jurnal->id,
                    'coa_id' => $item['coa_id'],
                    'debit' => $item['debit'] ?? 0,
                    'kredit' => $item['kredit'] ?? 0,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }
        });

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    // Hapus jurnal
    public function destroy(JurnalHeader $jurnal)
    {
        $jurnal->delete();
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Santri;
use App\Models\JenisPerizinan;
use App\Models\Kamar;
use App\Models\Pendidikan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PerizinanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perizinan::with(['santri.kamar', 'santri.kelas', 'jenisPerizinan'])->latest();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('id_santri', 'like', "%{$search}%");
            });
        }
        if ($request->filled('id_jenis_perizinan')) {
            $query->where('id_jenis_perizinan', $request->input('id_jenis_perizinan'));
        }
        if ($request->filled('id_kamar')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('id_kamar', $request->input('id_kamar'));
            });
        }
        if ($request->filled('id_kelas')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('id_kelas', $request->input('id_kelas'));
            });
        }

        $perizinans = $query->paginate(15)->appends(request()->query());
        
        $jenisPerizinans = JenisPerizinan::all();
        $kamars = Kamar::all();
        $pendidikans = Pendidikan::all();
        $kelases = Kelas::all();

        return view('perizinan.index', compact('perizinans', 'jenisPerizinans', 'kamars', 'pendidikans', 'kelases'));
    }

    public function create()
    {
        $jenisPerizinans = JenisPerizinan::all();
        return view('perizinan.create', compact('jenisPerizinans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'id_jenis_perizinan' => 'required|exists:jenis_perizinans,id_jenis_perizinan',
            'waktu_pergi' => 'required|date',
            'estimasi_kembali' => 'required|date|after_or_equal:waktu_pergi',
        ]);

        $prefix = 'IZ-' . date('Ym') . '-';
        $lastPerizinan = Perizinan::where('id_izin', 'like', $prefix . '%')
                                  ->orderBy('id_izin', 'desc')
                                  ->first();

        if ($lastPerizinan) {
            $lastNumber = (int) substr($lastPerizinan->id_izin, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }
        
        $validated['id_izin'] = $prefix . $nextNumber;
        $validated['status'] = 'Pengajuan'; 

        Perizinan::create($validated);
        return redirect()->route('perizinan.index')->with('success', 'Data perizinan berhasil ditambahkan.');
    }

    public function show(Perizinan $perizinan)
    {
        return view('perizinan.show', compact('perizinan'));
    }

    public function edit(Perizinan $perizinan)
    {
        $jenisPerizinans = JenisPerizinan::all();
        return view('perizinan.edit', compact('perizinan', 'jenisPerizinans'));
    }

    public function update(Request $request, Perizinan $perizinan)
    {
        $rules = [
            'estimasi_kembali' => 'required|date',
            'waktu_kembali_aktual' => 'nullable|date',
            'status' => 'required|in:Pengajuan,Diizinkan,Ditolak,Kembali,Terlambat'
        ];

        if ($request->filled('id_santri')) {
            $rules['id_santri'] = 'required|exists:santris,id_santri';
        }
        if ($request->filled('id_jenis_perizinan')) {
            $rules['id_jenis_perizinan'] = 'required|exists:jenis_perizinans,id_jenis_perizinan';
        }
        if ($request->filled('waktu_pergi')) {
            $rules['waktu_pergi'] = 'required|date';
        }

        $validated = $request->validate($rules);

        // LOGIKA BARU: Jika status "Kembali" tapi jam kosong, gunakan waktu saat ini
        if ($validated['status'] === 'Kembali' && empty($validated['waktu_kembali_aktual'])) {
            $validated['waktu_kembali_aktual'] = Carbon::now();
        }

        // LOGIKA BARU: Jika status dikembalikan ke proses lain, kosongkan jam kembalinya
        if ($validated['status'] !== 'Kembali' && $validated['status'] !== 'Terlambat') {
            $validated['waktu_kembali_aktual'] = null;
        }

        $perizinan->update($validated);
        
        return redirect()->route('perizinan.index')->with('success', 'Status perizinan berhasil diperbarui.');
    }

    public function destroy(Perizinan $perizinan)
    {
        $perizinan->delete();
        return redirect()->route('perizinan.index')->with('success', 'Data perizinan berhasil dihapus.');
    }

    public function searchSantri(Request $request)
    {
        $keyword = $request->input('q') ?? $request->input('search');

        $query = Santri::with(['pendidikan', 'kelas', 'kamar']);

        if ($keyword) {
            $query->where('nama_santri', 'like', "%{$keyword}%")
                  ->orWhere('id_santri', 'like', "%{$keyword}%");
        }

        $santris = $query->limit(15)->get();

        $formatted = $santris->map(function ($santri) {
            $data = $santri->toArray();
            $data['id'] = $santri->id_santri;
            $data['text'] = $santri->id_santri . ' - ' . $santri->nama_santri;
            return $data;
        });

        return response()->json($formatted);
    }

    public function detailPdf(Perizinan $perizinan)
    {
        $pdf = Pdf::loadView('perizinan.detail_pdf', compact('perizinan'));
        return $pdf->stream('Surat-Izin-' . $perizinan->santri->nama_santri . '.pdf');
    }

    public function print(Perizinan $perizinan)
    {
        return view('perizinan.print', compact('perizinan'));
    }
}
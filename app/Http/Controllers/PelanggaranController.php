<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\JenisPelanggaran;
use App\Models\Santri;
use App\Models\Kamar;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['santri.kamar', 'santri.kelas', 'jenisPelanggaran'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('id_santri', 'like', "%{$search}%");
            });
        }
        if ($request->filled('id_jenis_pelanggaran')) {
            $query->where('id_jenis_perizinan', $request->input('id_jenis_pelanggaran'));
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

        $pelanggarans = $query->paginate(15)->appends(request()->query());

        $jenisPelanggarans = JenisPelanggaran::all();
        $kamars = Kamar::all();
        $kelases = Kelas::all();

        return view('pelanggaran.index', compact('pelanggarans', 'jenisPelanggarans', 'kamars', 'kelases'));
    }

    public function create()
    {
        $jenisPelanggarans = JenisPelanggaran::all();
        return view('pelanggaran.create', compact('jenisPelanggarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'id_jenis_pelanggaran' => 'required|exists:jenis_pelanggarans,id_jenis_pelanggaran',
            'tanggal_melanggar' => 'required|date',
            'catatan_tindakan' => 'nullable|string',
        ]);

        $prefix = 'PLG-' . date('Ym') . '-';
        $lastPelanggaran = Pelanggaran::where('id_pelanggaran', 'like', $prefix . '%')
                                      ->orderBy('id_pelanggaran', 'desc')
                                      ->first();

        if ($lastPelanggaran) {
            $lastNumber = (int) substr($lastPelanggaran->id_pelanggaran, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $validated['id_pelanggaran'] = $prefix . $nextNumber;

        Pelanggaran::create($validated);
        return redirect()->route('pelanggaran.index')->with('success', 'Catatan pelanggaran santri berhasil ditambahkan.');
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $jenisPelanggarans = JenisPelanggaran::all();
        return view('pelanggaran.edit', compact('pelanggaran', 'jenisPelanggarans'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate([
            'id_jenis_pelanggaran' => 'required|exists:jenis_pelanggarans,id_jenis_pelanggaran',
            'tanggal_melanggar' => 'required|date',
            'catatan_tindakan' => 'nullable|string',
        ]);

        $pelanggaran->update($validated);
        return redirect()->route('pelanggaran.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();
        return redirect()->route('pelanggaran.index')->with('success', 'Catatan pelanggaran berhasil dihapus.');
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
}
<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenisPelanggarans = JenisPelanggaran::latest()->paginate(10);
        return view('jenispelanggaran.index', compact('jenisPelanggarans'));
    }

    public function create()
    {
        return view('jenispelanggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'poin_minus' => 'required|integer|min:0',
            'kategori' => 'required|in:Ringan,Sedang,Berat',
            'keterangan' => 'nullable|string'
        ]);

        JenisPelanggaran::create($validated);
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Master jenis pelanggaran berhasil ditambahkan.');
    }

    public function edit(JenisPelanggaran $jenis_pelanggaran)
    {
        return view('jenispelanggaran.edit', compact('jenis_pelanggaran'));
    }

    public function update(Request $request, JenisPelanggaran $jenis_pelanggaran)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'poin_minus' => 'required|integer|min:0',
            'kategori' => 'required|in:Ringan,Sedang,Berat',
            'keterangan' => 'nullable|string'
        ]);

        $jenis_pelanggaran->update($validated);
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Master jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(JenisPelanggaran $jenis_pelanggaran)
    {
        $jenis_pelanggaran->delete();
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Master jenis pelanggaran berhasil dihapus.');
    }
}
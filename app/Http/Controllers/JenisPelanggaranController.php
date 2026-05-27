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
        ]);

        // Isi otomatis di belakang layar agar database tidak error
        $validated['poin_minus'] = 0;
        $validated['kategori'] = 'Ringan';
        $validated['keterangan'] = '-';

        JenisPelanggaran::create($validated);
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    public function edit(JenisPelanggaran $jenis_pelanggaran)
    {
        return view('jenispelanggaran.edit', compact('jenis_pelanggaran'));
    }

    public function update(Request $request, JenisPelanggaran $jenis_pelanggaran)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
        ]);

        $jenis_pelanggaran->update($validated);
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy(JenisPelanggaran $jenis_pelanggaran)
    {
        $jenis_pelanggaran->delete();
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
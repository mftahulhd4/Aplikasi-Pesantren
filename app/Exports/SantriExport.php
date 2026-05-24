<?php

namespace App\Exports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SantriExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
<<<<<<< HEAD
    protected $name;
    protected $status;
    protected $pendidikan;
    protected $kelas;

    public function __construct($name, $status, $pendidikan, $kelas)
    {
        $this->name = $name;
        $this->status = $status;
        $this->pendidikan = $pendidikan;
        $this->kelas = $kelas;
=======
    protected $search;
    protected $statusId;
    protected $pendidikanId;
    protected $kelasId;
    protected $jenisKelamin;
    protected $kamarId; // Ditambahkan

    // [MODIFIKASI] Menambahkan $kamarId pada constructor
    public function __construct($search, $statusId, $pendidikanId, $kelasId, $jenisKelamin, $kamarId)
    {
        $this->search = $search;
        $this->statusId = $statusId;
        $this->pendidikanId = $pendidikanId;
        $this->kelasId = $kelasId;
        $this->jenisKelamin = $jenisKelamin;
        $this->kamarId = $kamarId; // Ditambahkan
>>>>>>> 4df13f002a3a0e56a3e018ac1a0d8e0ffe403fd8
    }

    public function query()
    {
<<<<<<< HEAD
        // Bagian ini tidak perlu diubah, query tetap sama
        return Santri::query()
            ->when($this->name, function ($query, $name) {
                return $query->where('nama_santri', 'like', '%' . $name . '%');
            })
            ->when($this->status, function ($query, $status) {
                return $query->where('id_status', $status);
            })
            ->when($this->pendidikan, function ($query, $pendidikan) {
                return $query->where('id_pendidikan', $pendidikan);
            })
            ->when($this->kelas, function ($query, $kelas) {
                return $query->where('id_kelas', $kelas);
            });
=======
        // [MODIFIKASI] Menambahkan relasi 'kamar' ke eager loading
        $query = Santri::query()->with(['pendidikan', 'kelas', 'status', 'kamar']);

        $query->when($this->search, function ($q, $search) {
            return $q->where(function($sub) use ($search) {
                $sub->where('nama_santri', 'like', '%' . $search . '%')
                    ->orWhere('id_santri', 'like', '%' . $search . '%');
            });
        })
        ->when($this->statusId, function ($q, $statusId) {
            return $q->where('id_status', $statusId);
        })
        ->when($this->pendidikanId, function ($q, $pendidikanId) {
            return $q->where('id_pendidikan', $pendidikanId);
        })
        ->when($this->kelasId, function ($q, $kelasId) {
            return $q->where('id_kelas', $kelasId);
        })
        ->when($this->jenisKelamin, function ($q, $jenisKelamin) {
            return $q->where('jenis_kelamin', $jenisKelamin);
        })
        // [DITAMBAHKAN] Menambahkan filter berdasarkan kamarId
        ->when($this->kamarId, function ($q, $kamarId) {
            return $q->where('id_kamar', $kamarId);
        });

        return $query;
>>>>>>> 4df13f002a3a0e56a3e018ac1a0d8e0ffe403fd8
    }

    /**
     * Mengatur judul header untuk setiap kolom di Excel.
     */
    public function headings(): array
    {
<<<<<<< HEAD
        // UBAH BAGIAN INI: Sesuaikan dengan judul kolom yang Anda inginkan
=======
        // [MODIFIKASI] Menambahkan header kolom 'Kamar'
>>>>>>> 4df13f002a3a0e56a3e018ac1a0d8e0ffe403fd8
        return [
            'ID Santri',
            'Nama Lengkap',
            'Tempat, Tgl Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Pendidikan',
            'Kelas',
<<<<<<< HEAD
=======
            'Kamar', // Ditambahkan
>>>>>>> 4df13f002a3a0e56a3e018ac1a0d8e0ffe403fd8
            'Tahun Masuk',
            'Status Santri',
            'Nama Ayah',
            'Nama Ibu',
            'No. HP Wali',
        ];
    }

    /**
     * @param Santri $santri
     * Mengambil dan memetakan data untuk setiap baris di Excel.
     */
    public function map($santri): array
    {
<<<<<<< HEAD
        // UBAH BAGIAN INI: Sesuaikan dengan data yang ingin ditampilkan
=======
        // [MODIFIKASI] Menambahkan data kamar ke array
>>>>>>> 4df13f002a3a0e56a3e018ac1a0d8e0ffe403fd8
        return [
            $santri->id_santri,
            $santri->nama_santri,
            $santri->tempat_lahir . ', ' . \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d-m-Y'),
            $santri->jenis_kelamin,
            $santri->alamat,
<<<<<<< HEAD
            $santri->pendidikan->nama_pendidikan,
            $santri->kelas->nama_kelas,
            $santri->tahun_masuk,
            $santri->status->nama_status,
=======
            $santri->pendidikan->nama_pendidikan ?? 'N/A',
            $santri->kelas->nama_kelas ?? 'N/A',
            $santri->kamar->nama_kamar ?? 'N/A', // Ditambahkan
            $santri->tahun_masuk,
            $santri->status->nama_status ?? 'N/A',
>>>>>>> 4df13f002a3a0e56a3e018ac1a0d8e0ffe403fd8
            $santri->nama_ayah,
            $santri->nama_ibu,
            $santri->nomor_hp_wali,
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'poin_minus',
        'kategori',
        'keterangan',
    ];

    public function pelanggarans(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'id_jenis_pelanggaran', 'id_jenis_pelanggaran');
    }
}
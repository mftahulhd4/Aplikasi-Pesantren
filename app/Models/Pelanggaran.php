<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelanggaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pelanggaran',
        'id_santri',
        'id_jenis_pelanggaran',
        'tanggal_melanggar',
        'catatan_tindakan',
    ];

    protected $casts = [
        'tanggal_melanggar' => 'date',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'id_santri', 'id_santri');
    }

    public function jenisPelanggaran(): BelongsTo
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id_jenis_pelanggaran', 'id_jenis_pelanggaran');
    }
}
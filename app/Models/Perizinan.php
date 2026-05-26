<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perizinan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_izin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_izin',
        'id_santri',
        'id_jenis_perizinan',
        'waktu_pergi',
        'estimasi_kembali',
        'waktu_kembali_aktual',
        'status',
    ];
    
    protected $casts = [
        'waktu_pergi' => 'datetime',
        'estimasi_kembali' => 'datetime',
        'waktu_kembali_aktual' => 'datetime',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'id_santri', 'id_santri');
    }

    public function jenisPerizinan(): BelongsTo
    {
        return $this->belongsTo(JenisPerizinan::class, 'id_jenis_perizinan', 'id_jenis_perizinan');
    }

    // Mengatur Status Tampilan (Efektif)
    protected function statusEfektif(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                // 1. Jika masih di luar dan waktu sudah lewat estimasi
                if ($attributes['status'] === 'Diizinkan' && now()->isAfter($attributes['estimasi_kembali'])) {
                    return 'Terlambat';
                }
                
                // 2. PERBAIKAN: Jika sudah "Kembali", tapi waktu kembali aktualnya telat
                if ($attributes['status'] === 'Kembali' && !empty($attributes['waktu_kembali_aktual'])) {
                    $estimasi = Carbon::parse($attributes['estimasi_kembali']);
                    $aktual = Carbon::parse($attributes['waktu_kembali_aktual']);
                    
                    if ($aktual->isAfter($estimasi)) {
                        return 'Kembali (Terlambat)';
                    }
                }
                
                return $attributes['status'];
            }
        );
    }

    // Mengatur Perhitungan Durasi Waktu Keterlambatan
    protected function durasiKeterlambatan(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                // 1. PERBAIKAN: Hitung keterlambatan jika ada waktu aktual yang melewati estimasi
                if (!empty($attributes['waktu_kembali_aktual'])) {
                    $estimasi = Carbon::parse($attributes['estimasi_kembali']);
                    $aktual = Carbon::parse($attributes['waktu_kembali_aktual']);
                    
                    if ($aktual->isAfter($estimasi)) {
                        return $estimasi->diffForHumans($aktual, true); // true = format tanpa kata "setelah/sebelum"
                    }
                }
                
                // 2. Jika santri belum kembali (waktu aktual masih kosong) tapi sudah melewati estimasi
                if (in_array($attributes['status'], ['Diizinkan', 'Terlambat']) && now()->isAfter($attributes['estimasi_kembali'])) {
                    return Carbon::parse($attributes['estimasi_kembali'])->diffForHumans(now(), true);
                }
                
                return null;
            }
        );
    }
}
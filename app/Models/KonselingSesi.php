<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonselingSesi extends Model
{
    use HasFactory;

    protected $table = 'konseling_sesi';

    protected $fillable = [
        'konseling_id',
        'ke',
        'tanggal',
        'durasi',
        'deskripsi_masalah',
        'tindakan_konselor',
        'rekomendasi',
        'tindak_lanjut',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'ke'      => 'integer',
        'durasi'  => 'integer',
    ];

    // Relasi ke kasus konseling
    public function konseling()
    {
        return $this->belongsTo(Konseling::class, 'konseling_id');
    }
}
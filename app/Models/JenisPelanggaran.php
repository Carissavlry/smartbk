<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama',
        'deskripsi',
        'poin',
        'kategori',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'poin'     => 'integer',
    ];

    // Scope: hanya yang aktif
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    // Label kategori
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'berat'  => 'Berat',
            default  => '-',
        };
    }

    // Warna badge kategori
    public function getKategoriBadgeAttribute(): string
    {
        return match($this->kategori) {
            'ringan' => 'badge-yellow',
            'sedang' => 'badge-orange',
            'berat'  => 'badge-red',
            default  => 'badge-gray',
        };
    }
}
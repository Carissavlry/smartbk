<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'nama',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif'        => 'boolean',
    ];

    // Scope untuk ambil tahun ajaran aktif
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    // Relasi ke Kelas (nanti)
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    // Label lengkap: 2024/2025 - Ganjil
    public function getLabelAttribute(): string
    {
        return $this->nama . ' - ' . $this->semester;
    }
}
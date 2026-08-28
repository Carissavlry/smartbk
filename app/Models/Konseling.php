<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'guru_bk_id',
        'kategori',
        'deskripsi_masalah',
        'status',
    ];

    // Status konseling
    const STATUS_BARU          = 'baru';
    const STATUS_DALAM_PROSES  = 'dalam_proses';
    const STATUS_SELESAI       = 'selesai';

    protected function status(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn($value) => strtolower(str_replace(' ', '_', $value)),
            set: fn($value) => match(strtolower($value)) {
                'baru'         => 'Baru',
                'dalam_proses' => 'Dalam Proses',
                'selesai'      => 'Selesai',
                default        => $value,
            },
        );
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Relasi ke guru BK
    public function guruBk()
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    // Relasi ke semua sesi
    public function sesi()
    {
        return $this->hasMany(KonselingSesi::class, 'konseling_id')->orderBy('ke');
    }

    // Sesi terakhir
    public function sesiTerakhir()
    {
        return $this->hasOne(KonselingSesi::class, 'konseling_id')->latestOfMany('ke');
    }

    // Total sesi
    public function getTotalSesiAttribute(): int
    {
        return $this->sesi()->count();
    }

    // Label status
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'baru'         => 'Baru',
            'dalam_proses' => 'Dalam Proses',
            'selesai'      => 'Selesai',
            default        => '-',
        };
    }

    // Badge warna status
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'baru'         => 'badge-blue',
            'dalam_proses' => 'badge-yellow',
            'selesai'      => 'badge-green',
            default        => 'badge-gray',
        };
    }
}
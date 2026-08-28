<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'guru_bk_id',
        'judul',
        'isi',
        'kategori',
        'target',
        'is_pinned',
        'published_at',
    ];

    protected $casts = [
        'is_pinned'    => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relasi ke Guru BK (User)
    public function guruBk()
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    // Label kategori
    public function kategoriLabel(): string
    {
        return match($this->kategori) {
            'pribadi_sosial' => 'Pribadi & Sosial',
            'belajar'        => 'Belajar & Akademik',
            'karir'          => 'Karir & Masa Depan',
            'info_umum'      => 'Info Umum',
            default          => '-',
        };
    }

    public function kategoriBadgeColor(): string
    {
        return match($this->kategori) {
            'pribadi_sosial' => '#ec4899',
            'belajar'        => '#3b82f6',
            'karir'          => '#f59e0b',
            'info_umum'      => '#10b981',
            default          => '#94a3b8',
        };
    }
}
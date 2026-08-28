<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonselingPengajuan extends Model
{
    protected $table = 'konseling_pengajuan';

    protected $fillable = [
        'siswa_id',
        'guru_bk_id',
        'tanggal_diajukan',
        'jam_diajukan',
        'topik',
        'deskripsi',
        'status',
        'alasan_tolak',
        'tanggal_reschedule',
        'jam_reschedule',
        'catatan_reschedule',
        'konseling_id',
    ];

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

    // Relasi ke konseling (jika disetujui)
    public function konseling()
    {
        return $this->belongsTo(Konseling::class, 'konseling_id');
    }

    // Badge warna status untuk UI
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => 'warning',
            'disetujui'  => 'success',
            'ditolak'    => 'danger',
            'reschedule' => 'info',
            'selesai'    => 'secondary',
            default      => 'secondary',
        };
    }

    // Label status dalam Bahasa Indonesia
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => 'Menunggu',
            'disetujui'  => 'Disetujui',
            'ditolak'    => 'Ditolak',
            'reschedule' => 'Reschedule',
            'selesai'    => 'Selesai',
            default      => 'Tidak Diketahui',
        };
    }
}
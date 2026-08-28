<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVisit extends Model
{
    protected $fillable = [
        'nomor_surat',
        'siswa_id',
        'guru_bk_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'alamat',
        'nama_ortu',
        'no_hp_ortu',
        'status_kehadiran_ortu',
        'yang_menemani',
        'tujuan',
        'hasil',
        'kondisi_lingkungan',
        'kesimpulan',
        'rekomendasi',
        'tindak_lanjut',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guruBk()
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    public function fotos()
    {
        return $this->hasMany(HomeVisitFoto::class);
    }

    // Auto-generate nomor surat
    public static function generateNomorSurat(): string
    {
        $tahun  = date('Y');
        $bulan  = date('m');
        $count  = self::whereYear('created_at', $tahun)
                      ->whereMonth('created_at', $bulan)
                      ->count() + 1;
        return sprintf('HV/%s/%s/%03d', $tahun, $bulan, $count);
    }
}
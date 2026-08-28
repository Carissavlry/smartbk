<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPeringatan extends Model
{
    protected $table = 'surat_peringatan';

    protected $fillable = [
        'nomor_surat',
        'user_id',
        'jenis_surat',
        'level',
        'total_poin',
        'tanggal_surat',
        'isi_surat',
        'catatan',
        'dibuat_oleh',
        'status',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function guruBk()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'surat_peringatan_id');
    }

    public static function generateNomor(string $level): string
    {
        $bulan = [
            1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',
            7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'
        ];
        $levelMap = ['kuning' => 1, 'merah' => 2, 'hitam' => 3];
        $lvl   = $levelMap[$level] ?? 1;
        $count = self::whereYear('created_at', now()->year)
                     ->where('level', $level)
                     ->count() + 1;
        $urut  = str_pad($count, 3, '0', STR_PAD_LEFT);
        $bln   = $bulan[now()->month];
        $thn   = now()->year;
        return "{$urut}/SP{$lvl}/BK/{$bln}/{$thn}";
    }
}
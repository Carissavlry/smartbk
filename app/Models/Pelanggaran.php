<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $fillable = [
        'user_id',
        'jenis_pelanggaran_id',
        'dicatat_oleh',
        'tanggal',
        'keterangan',
        'poin',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenis_pelanggaran_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    // Total poin pelanggaran siswa
    public static function totalPoinSiswa($userId)
    {
        return self::where('user_id', $userId)->sum('poin');
    }
}
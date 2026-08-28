<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = [
        'user_id',
        'dicatat_oleh',
        'nama_prestasi',
        'jenis',
        'tingkat',
        'peringkat',
        'penyelenggara',
        'tanggal',
        'keterangan',
        'bukti',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
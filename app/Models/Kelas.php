<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = [
        'tahun_ajaran_id',
        'guru_id',
        'nama',
        'tingkat',
        'jurusan',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function siswas()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->nama;
    }

    // Accessor agar bisa dipanggil ->nama_kelas maupun ->nama
    public function getNamaKelasAttribute(): string
    {
        return $this->nama;
    }
}
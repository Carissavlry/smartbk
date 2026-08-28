<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'nis', 'nip', 'kelas_id', 'jenis_kelamin', 'no_hp', 'pendidikan_terakhir', 'tahun_mulai_bertugas', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama', 'nama_ortu', 'no_hp_ortu', 'foto', 'password', 'google_id', 'google_email', 'is_first_login'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Kelas (untuk siswa)
    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class);
    }

    // Relasi ke Kelas (untuk Guru BK — bisa pegang banyak kelas)
    public function kelasBindaan()
    {
        return $this->hasMany(\App\Models\Kelas::class, 'guru_id');
    }

    // Relasi ke Pelanggaran (untuk siswa)
    public function pelanggarans()
    {
        return $this->hasMany(\App\Models\Pelanggaran::class, 'user_id');
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class, 'user_id');
    }

    public function suratPeringatan()
    {
        return $this->hasMany(SuratPeringatan::class, 'user_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->whereNull('read_at')->count();
    }

    public function getTotalPoinPelanggaranAttribute(): int
    {
        return $this->pelanggarans()->sum('poin');
    }

    public function konselings()
    {
        return $this->hasMany(\App\Models\Konseling::class, 'siswa_id');
    }
}

<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class SiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    private $kelasCache = [];
    public $importedCount = 0;
    public $skippedCount = 0;

    public function model(array $row)
    {
        // Skip baris kosong
        if (empty($row['nis']) || empty($row['nama_lengkap'])) {
            $this->skippedCount++;
            return null;
        }

        // Skip jika NIS sudah ada
        if (User::where('nis', $row['nis'])->exists()) {
            $this->skippedCount++;
            return null;
        }

        // Cari kelas berdasarkan nama
        $kelasId = null;
        if (!empty($row['kelas'])) {
            $namaKelas = trim($row['kelas']);
            if (!isset($this->kelasCache[$namaKelas])) {
                $kelas = Kelas::whereRaw('LOWER(nama) = ?', [strtolower($namaKelas)])->first();
                $this->kelasCache[$namaKelas] = $kelas?->id;
            }
            $kelasId = $this->kelasCache[$namaKelas];
        }

        // Tentukan jenis kelamin
        $jk = strtolower(trim($row['jenis_kelamin'] ?? ''));
        if (in_array($jk, ['l', 'laki-laki', 'laki laki', 'male'])) {
            $jenisKelamin = 'Laki-laki';
        } elseif (in_array($jk, ['p', 'perempuan', 'female'])) {
            $jenisKelamin = 'Perempuan';
        } else {
            $jenisKelamin = 'Laki-laki'; // default
        }

        $this->importedCount++;

        $user = new User([
            'name'           => trim($row['nama_lengkap']),
            'nis'            => trim($row['nis']),
            'email'          => !empty($row['email']) ? trim($row['email']) : null,
            'password'       => Hash::make($row['nis']),
            'jenis_kelamin'  => $jenisKelamin,
            'kelas_id'       => $kelasId,
            'no_hp'          => $row['no_hp'] ?? null,
            'nama_ortu'      => $row['nama_orang_tua'] ?? null,
            'no_hp_ortu'     => $row['no_hp_orang_tua'] ?? null,
            'alamat'         => $row['alamat'] ?? null,
            'is_first_login' => true,
        ]);

        $user->save();
        $user->assignRole('siswa');

        return null; // return null karena sudah save manual
    }
}
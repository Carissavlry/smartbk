<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 3 Role
        $adminRole  = Role::firstOrCreate(['name' => 'admin_sekolah']);
        $guruBkRole = Role::firstOrCreate(['name' => 'guru_bk']);
        $siswaRole  = Role::firstOrCreate(['name' => 'siswa']);

        // User default Admin Sekolah (login pakai email)
        $admin = User::firstOrCreate(
            ['email' => 'admin@smartbk.sch.id'],
            [
                'name'           => 'Admin Sekolah',
                'email'          => 'admin@smartbk.sch.id',
                'password'       => Hash::make('admin123'),
                'is_first_login' => false,
            ]
        );
        $admin->syncRoles($adminRole);

        // User default Guru BK (login pakai NIP)
        $guru = User::firstOrCreate(
            ['nip' => '198501012010011001'],
            [
                'name'           => 'Guru BK',
                'email'          => 'gurubk@smartbk.sch.id',
                'nip'            => '198501012010011001',
                'password'       => Hash::make('gurubk123'),
                'is_first_login' => false,
            ]
        );
        $guru->syncRoles($guruBkRole);

        // User default Siswa (login pakai NIS)
        $siswa = User::firstOrCreate(
            ['nis' => '1234567890'],
            [
                'name'           => 'Siswa Demo',
                'email'          => 'siswa@smartbk.sch.id',
                'nis'            => '1234567890',
                'password'       => Hash::make('siswa123'),
                'is_first_login' => false,
            ]
        );
        $siswa->syncRoles($siswaRole);
    }
}
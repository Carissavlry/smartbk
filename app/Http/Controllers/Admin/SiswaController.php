<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('siswa')->with('kelas');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $siswas    = $query->orderBy('name')->paginate(15)->withQueryString();
        $kelasList = Kelas::orderBy('nama')->get();

        return view('admin.siswa.index', compact('siswas', 'kelasList'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('admin.siswa.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'nis'           => 'required|string|max:20|unique:users,nis',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id'      => 'required|exists:kelas,id',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string|max:255',
            'nama_ortu'     => 'nullable|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'no_hp_ortu'    => 'nullable|string|max:20',
            'email'         => 'nullable|email|unique:users,email',
            'password'      => 'nullable|string|min:6',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'agama'         => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa = User::create([
            'name'           => $request->name,
            'nis'            => $request->nis,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'kelas_id'       => $request->kelas_id,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'nama_ortu'      => $request->nama_ortu,
            'no_hp'          => $request->no_hp,
            'no_hp_ortu'     => $request->no_hp_ortu,
            'email'          => $request->email,
            'password'       => Hash::make($request->filled('password') ? $request->password : 'siswa123'),
            'foto'           => $fotoPath,
            'is_first_login' => true,
            'agama'          => $request->agama,
        ]);

        $siswa->assignRole('siswa');

        ActivityLog::record('CREATE', 'Siswa', "Menambah siswa: {$siswa->name} (NIS: {$siswa->nis})", $siswa);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(User $siswa)
    {
        $siswa->load('kelas');
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(User $siswa)
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelasList'));
    }

    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'nis'           => 'required|string|max:20|unique:users,nis,' . $siswa->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id'      => 'required|exists:kelas,id',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string|max:255',
            'nama_ortu'     => 'nullable|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'no_hp_ortu'    => 'nullable|string|max:20',
            'email'         => 'nullable|email|unique:users,email,' . $siswa->id,
            'password'      => 'nullable|string|min:6',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'agama'         => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
        ]);

        $fotoPath = $siswa->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath) Storage::disk('public')->delete($fotoPath);
            $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->update([
            'name'          => $request->name,
            'nis'           => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id'      => $request->kelas_id,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'nama_ortu'     => $request->nama_ortu,
            'no_hp'         => $request->no_hp,
            'no_hp_ortu'    => $request->no_hp_ortu,
            'email'         => $request->email,
            'foto'          => $fotoPath,
            'agama'         => $request->agama,
        ]);

        if ($request->filled('password')) {
            $siswa->update(['password' => Hash::make($request->password)]);
        }

        ActivityLog::record('UPDATE', 'Siswa', "Mengubah data siswa: {$siswa->name} (NIS: {$siswa->nis})", $siswa);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(User $siswa)
    {
        $nama = $siswa->name;
        $nis  = $siswa->nis;

        if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
        $siswa->delete();

        ActivityLog::record('DELETE', 'Siswa', "Menghapus siswa: {$nama} (NIS: {$nis})");

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus.');
    }

    public function importForm()
    {
        return view('admin.siswa.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new SiswaImport();
        Excel::import($import, $request->file('file'));

        $imported = $import->importedCount;
        $skipped  = $import->skippedCount;

        ActivityLog::record('IMPORT', 'Siswa', "Import siswa: {$imported} berhasil, {$skipped} dilewati");

        $message = $imported . ' siswa berhasil diimport.';
        if ($skipped > 0) {
            $message .= ' ' . $skipped . ' baris dilewati (NIS duplikat atau data kosong).';
        }

        return redirect()->route('admin.siswa.index')->with('success', $message);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_siswa.csv"',
        ];

        $columns = ['nis', 'nama_lengkap', 'jenis_kelamin', 'kelas', 'no_hp', 'email', 'nama_orang_tua', 'no_hp_orang_tua', 'alamat'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['1234567890', 'Nama Siswa', 'Laki-laki', 'XI RPL 1', '08123456789', 'email@contoh.com', 'Nama Orang Tua', '08198765432', 'Alamat lengkap']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Tidak ada siswa yang dipilih.');
        }

        $siswas = User::role('siswa')->whereIn('id', $ids)->get();
        $jumlah = count($siswas);
        $nama   = $siswas->pluck('name')->join(', ');

        foreach ($siswas as $siswa) {
            if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
            $siswa->delete();
        }

        ActivityLog::record('DELETE', 'Siswa', "Bulk delete {$jumlah} siswa: {$nama}");

        return redirect()->route('admin.siswa.index')
            ->with('success', "{$jumlah} siswa berhasil dihapus.");
    }

    public function resetPassword(User $siswa)
    {
        $siswa->update([
            'password'       => Hash::make('siswa123'),
            'is_first_login' => true,
        ]);

        ActivityLog::record('UPDATE', 'Siswa', "Reset password siswa: {$siswa->name} (NIS: {$siswa->nis})", $siswa);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Password siswa berhasil direset ke: siswa123');
    }

    public function kartu(User $siswa)
    {
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(100)
            ->generate(route('admin.siswa.show', $siswa));

        $config = (object)[
            'nama_sekolah'   => \App\Models\Setting::get('nama_sekolah', 'SmartBK'),
            'alamat_sekolah' => \App\Models\Setting::get('alamat_sekolah', 'Sistem Informasi Bimbingan Konseling'),
            'logo'           => \App\Models\Setting::get('logo_sekolah', null),
        ];

        return view('admin.siswa.kartu', compact('siswa', 'qrCode', 'config'));
    }

    public function kartuPrint(User $siswa)
    {
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate(route('admin.siswa.show', $siswa));

        return view('admin.siswa.kartu-print', compact('siswa', 'qrCode'));
    }
}
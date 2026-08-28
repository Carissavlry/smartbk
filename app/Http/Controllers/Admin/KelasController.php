<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with(['tahunAjaran', 'guru']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%')
                ->orWhere('jurusan', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $kelas = $query->orderBy('tingkat')->orderBy('nama')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('is_aktif')->orderByDesc('created_at')->get();

        return view('admin.kelas.index', compact('kelas', 'tahunAjarans'));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::orderByDesc('is_aktif')
                                   ->orderByDesc('created_at')
                                   ->get();

        $guruList = User::role('guru_bk')
                        ->orderBy('name')
                        ->get();

        return view('admin.kelas.create', compact('tahunAjarans', 'guruList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nama'            => 'required|string|max:50',
            'tingkat'         => 'required|in:X,XI,XII',
            'jurusan'         => 'nullable|string|max:50',
            'guru_id'         => 'nullable|exists:users,id',
        ]);

        $kelas = Kelas::create($request->only([
            'tahun_ajaran_id',
            'nama',
            'tingkat',
            'jurusan',
            'guru_id',
        ]));

        ActivityLog::record('CREATE', 'Kelas', "Menambah kelas: {$kelas->nama} (Tingkat: {$kelas->tingkat})", $kelas);

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $tahunAjarans = TahunAjaran::orderByDesc('is_aktif')
                                   ->orderByDesc('created_at')
                                   ->get();

        $guruList = User::role('guru_bk')
                        ->orderBy('name')
                        ->get();

        return view('admin.kelas.edit', compact('kelas', 'tahunAjarans', 'guruList'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nama'            => 'required|string|max:50',
            'tingkat'         => 'required|in:X,XI,XII',
            'jurusan'         => 'nullable|string|max:50',
            'guru_id'         => 'nullable|exists:users,id',
        ]);

        $kelas->update($request->only([
            'tahun_ajaran_id',
            'nama',
            'tingkat',
            'jurusan',
            'guru_id',
        ]));

        ActivityLog::record('UPDATE', 'Kelas', "Mengubah kelas: {$kelas->nama} (Tingkat: {$kelas->tingkat})", $kelas);

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        // Cek apakah masih ada siswa di kelas ini
        $jumlahSiswa = User::where('kelas_id', $kelas->id)->count();

        if ($jumlahSiswa > 0) {
            return redirect()->route('admin.kelas.index')
                             ->with('error', "Kelas tidak bisa dihapus karena masih ada {$jumlahSiswa} siswa.");
        }

        $nama    = $kelas->nama;
        $tingkat = $kelas->tingkat;
        $kelas->delete();

        ActivityLog::record('DELETE', 'Kelas', "Menghapus kelas: {$nama} (Tingkat: {$tingkat})");

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil dihapus.');
    }
}
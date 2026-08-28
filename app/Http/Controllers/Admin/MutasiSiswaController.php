<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MutasiSiswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = MutasiSiswa::with(['siswa', 'kelasAsal', 'kelasTujuan', 'dicatatOleh'])
            ->latest();

        // Filter jenis mutasi
        if ($request->filled('jenis_mutasi')) {
            $query->where('jenis_mutasi', $request->jenis_mutasi);
        }

        // Filter search nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $mutasi = $query->paginate(15)->withQueryString();

        return view('admin.mutasi-siswa.index', compact('mutasi'));
    }

    public function create()
    {
        $siswa = User::role('siswa')->orderBy('name')->get();
        $kelas = Kelas::orderBy('nama')->get();

        return view('admin.mutasi-siswa.create', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'jenis_mutasi'   => 'required|in:masuk,keluar,internal',
            'tanggal_mutasi' => 'required|date',
            'alasan'         => 'nullable|string|max:500',
            'kelas_asal_id'  => 'nullable|exists:kelas,id',
            'kelas_tujuan_id'=> 'nullable|exists:kelas,id',
            'sekolah_asal'   => 'nullable|string|max:255',
            'sekolah_tujuan' => 'nullable|string|max:255',
        ]);

        MutasiSiswa::create([
            'user_id'         => $request->user_id,
            'jenis_mutasi'    => $request->jenis_mutasi,
            'kelas_asal_id'   => $request->kelas_asal_id,
            'kelas_tujuan_id' => $request->kelas_tujuan_id,
            'sekolah_asal'    => $request->sekolah_asal,
            'sekolah_tujuan'  => $request->sekolah_tujuan,
            'tanggal_mutasi'  => $request->tanggal_mutasi,
            'alasan'          => $request->alasan,
            'dicatat_oleh'    => Auth::id(),
        ]);

        // Jika mutasi keluar → nonaktifkan akun siswa
        if ($request->jenis_mutasi === 'keluar') {
            $siswa = User::findOrFail($request->user_id);
            $siswa->update(['is_active' => false]);
        }

        // Jika mutasi internal → update kelas siswa
        if ($request->jenis_mutasi === 'internal' && $request->kelas_tujuan_id) {
            $siswa = User::findOrFail($request->user_id);
            $siswa->update(['kelas_id' => $request->kelas_tujuan_id]);
        }

        return redirect()->route('admin.mutasi-siswa.index')
            ->with('success', 'Data mutasi siswa berhasil dicatat.');
    }

    public function show(MutasiSiswa $mutasiSiswa)
    {
        $mutasiSiswa->load(['siswa', 'kelasAsal', 'kelasTujuan', 'dicatatOleh']);
        return view('admin.mutasi-siswa.show', compact('mutasiSiswa'));
    }

    public function edit(MutasiSiswa $mutasiSiswa)
    {
        $siswa = User::role('siswa')->orderBy('name')->get();
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.mutasi-siswa.edit', compact('mutasiSiswa', 'siswa', 'kelas'));
    }

    public function update(Request $request, MutasiSiswa $mutasiSiswa)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'jenis_mutasi'    => 'required|in:masuk,keluar,internal',
            'tanggal_mutasi'  => 'required|date',
            'alasan'          => 'nullable|string|max:500',
            'kelas_asal_id'   => 'nullable|exists:kelas,id',
            'kelas_tujuan_id' => 'nullable|exists:kelas,id',
            'sekolah_asal'    => 'nullable|string|max:255',
            'sekolah_tujuan'  => 'nullable|string|max:255',
        ]);

        $mutasiSiswa->update([
            'user_id'         => $request->user_id,
            'jenis_mutasi'    => $request->jenis_mutasi,
            'kelas_asal_id'   => $request->kelas_asal_id,
            'kelas_tujuan_id' => $request->kelas_tujuan_id,
            'sekolah_asal'    => $request->sekolah_asal,
            'sekolah_tujuan'  => $request->sekolah_tujuan,
            'tanggal_mutasi'  => $request->tanggal_mutasi,
            'alasan'          => $request->alasan,
        ]);

        return redirect()->route('admin.mutasi-siswa.index')
            ->with('success', 'Data mutasi siswa berhasil diperbarui.');
    }

    public function destroy(MutasiSiswa $mutasiSiswa)
    {
        $mutasiSiswa->delete();

        return redirect()->route('admin.mutasi-siswa.index')
            ->with('success', 'Data mutasi berhasil dihapus.');
    }
}
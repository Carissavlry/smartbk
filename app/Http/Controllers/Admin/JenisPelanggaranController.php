<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = JenisPelanggaran::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('is_aktif', $request->status === 'aktif' ? 1 : 0);
        }

        $data = $query->orderBy('kategori')->orderBy('nama')->get();

        return view('admin.jenis-pelanggaran.index', compact('data'));
    }

    public function create()
    {
        return view('admin.jenis-pelanggaran.create');
    }

    public function store(Request $request)
    {
        \Log::info('STORE HIT', $request->all());

        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:ringan,sedang,berat',
            'poin'      => 'required|integer|min:0|max:100',
            'deskripsi' => 'nullable|string|max:500',
            'is_aktif'  => 'nullable',
        ]);

        \Log::info('VALIDATION PASSED');

        $jenis = JenisPelanggaran::create([
            'nama'      => $request->nama,
            'kategori'  => $request->kategori,
            'poin'      => $request->poin,
            'deskripsi' => $request->deskripsi,
            'is_aktif'  => $request->has('is_aktif') ? true : false,
        ]);

        ActivityLog::record('CREATE', 'Jenis Pelanggaran', "Menambah jenis pelanggaran: {$jenis->nama} ({$jenis->kategori}, {$jenis->poin} poin)", $jenis);

        return redirect()->route('admin.jenis-pelanggaran.index')
                        ->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function edit(JenisPelanggaran $jenisPelanggaran)
    {
        return view('admin.jenis-pelanggaran.edit', compact('jenisPelanggaran'));
    }

    public function update(Request $request, JenisPelanggaran $jenisPelanggaran)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:ringan,sedang,berat',
            'poin'      => 'required|integer|min:0|max:100',
            'deskripsi' => 'nullable|string|max:500',
            'is_aktif'  => 'nullable',
        ]);

        $jenisPelanggaran->update([
            'nama'      => $request->nama,
            'kategori'  => $request->kategori,
            'poin'      => $request->poin,
            'deskripsi' => $request->deskripsi,
            'is_aktif'  => $request->has('is_aktif') ? true : false,
        ]);

        ActivityLog::record('UPDATE', 'Jenis Pelanggaran', "Mengubah jenis pelanggaran: {$jenisPelanggaran->nama} ({$jenisPelanggaran->kategori}, {$jenisPelanggaran->poin} poin)", $jenisPelanggaran);

        return redirect()->route('admin.jenis-pelanggaran.index')
                         ->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(JenisPelanggaran $jenisPelanggaran)
    {
        $nama     = $jenisPelanggaran->nama;
        $kategori = $jenisPelanggaran->kategori;
        $jenisPelanggaran->delete();

        ActivityLog::record('DELETE', 'Jenis Pelanggaran', "Menghapus jenis pelanggaran: {$nama} ({$kategori})");

        return redirect()->route('admin.jenis-pelanggaran.index')
                         ->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}
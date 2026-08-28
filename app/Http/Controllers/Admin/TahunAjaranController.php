<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderByDesc('created_at')->get();
        return view('admin.tahun-ajaran.index', compact('tahunAjarans'));
    }

    public function create()
    {
        return view('admin.tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => [
                'required', 'string', 'max:20',
                \Illuminate\Validation\Rule::unique('tahun_ajarans')
                    ->where('semester', $request->semester),
            ],
            'semester'        => 'required|in:Ganjil,Genap',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'nama.unique' => 'Tahun ajaran :input dengan semester ' . $request->semester . ' sudah ada.',
        ]);

        // Jika is_aktif dicentang, nonaktifkan semua yang lain dulu
        if ($request->boolean('is_aktif')) {
            TahunAjaran::query()->update(['is_aktif' => false]);
        }

        $tahunAjaran = TahunAjaran::create([
            'nama'            => $request->nama,
            'semester'        => $request->semester,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_aktif'        => $request->boolean('is_aktif'),
        ]);

        ActivityLog::record('CREATE', 'Tahun Ajaran', "Menambah tahun ajaran: {$tahunAjaran->nama} {$tahunAjaran->semester}");

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'nama'            => [
                'required', 'string', 'max:20',
                \Illuminate\Validation\Rule::unique('tahun_ajarans')
                    ->where('semester', $request->semester)
                    ->ignore($tahunAjaran->id),
            ],
            'semester'        => 'required|in:Ganjil,Genap',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'nama.unique' => 'Tahun ajaran :input dengan semester ' . $request->semester . ' sudah ada.',
        ]);

        if ($request->boolean('is_aktif')) {
            TahunAjaran::query()->where('id', '!=', $tahunAjaran->id)
                ->update(['is_aktif' => false]);
        }

        $tahunAjaran->update([
            'nama'            => $request->nama,
            'semester'        => $request->semester,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_aktif'        => $request->boolean('is_aktif'),
        ]);

        ActivityLog::record('UPDATE', 'Tahun Ajaran', "Mengubah tahun ajaran: {$tahunAjaran->nama} {$tahunAjaran->semester}");

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $nama = $tahunAjaran->nama;
        $semester = $tahunAjaran->semester;
        $tahunAjaran->delete();

        ActivityLog::record('DELETE', 'Tahun Ajaran', "Menghapus tahun ajaran: {$nama} {$semester}");

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function setAktif(TahunAjaran $tahunAjaran)
    {
        TahunAjaran::query()->update(['is_aktif' => false]);
        $tahunAjaran->update(['is_aktif' => true]);

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$tahunAjaran->label} sekarang aktif.");
    }
}
<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $guruBk   = Auth::user();
        $search   = $request->get('search');
        $jenis    = $request->get('jenis');
        $tingkat  = $request->get('tingkat');

        $siswaIds = User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))
            ->whereHas('kelas', fn($q) => $q->where('guru_id', $guruBk->id))
            ->pluck('id');

        $prestasis = Prestasi::whereIn('user_id', $siswaIds)
            ->with(['siswa.kelas'])
            ->when($search, fn($q) =>
                $q->whereHas('siswa', fn($s) =>
                    $s->where('name', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%")
                )
            )
            ->when($jenis,   fn($q) => $q->where('jenis', $jenis))
            ->when($tingkat, fn($q) => $q->where('tingkat', $tingkat))
            ->latest('tanggal')
            ->paginate(15);

        return view('guru-bk.prestasi.index', compact(
            'prestasis', 'search', 'jenis', 'tingkat'
        ));
    }

    public function create()
    {
        $guruBk = Auth::user();
        $siswas = User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))
            ->whereHas('kelas', fn($q) => $q->where('guru_id', $guruBk->id))
            ->orderBy('name')->get();

        return view('guru-bk.prestasi.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'nama_prestasi' => 'required|string|max:255',
            'jenis'         => 'required|in:Akademik,Non-Akademik',
            'tingkat'       => 'required|in:Sekolah,Kecamatan,Kota,Provinsi,Nasional,Internasional',
            'peringkat'     => 'nullable|string',
            'penyelenggara' => 'nullable|string|max:255',
            'tanggal'       => 'required|date',
            'keterangan'    => 'nullable|string',
            'bukti'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('bukti');
        $data['dicatat_oleh'] = Auth::id();

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('prestasi', 'public');
        }

        Prestasi::create($data);

        return redirect()->route('guru-bk.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function show(Prestasi $prestasi)
    {
        return view('guru-bk.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $guruBk = Auth::user();
        $siswas = User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))
            ->whereHas('kelas', fn($q) => $q->where('guru_id', $guruBk->id))
            ->orderBy('name')->get();

        return view('guru-bk.prestasi.edit', compact('prestasi', 'siswas'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'jenis'         => 'required|in:Akademik,Non-Akademik',
            'tingkat'       => 'required|in:Sekolah,Kecamatan,Kota,Provinsi,Nasional,Internasional',
            'peringkat'     => 'nullable|string',
            'penyelenggara' => 'nullable|string|max:255',
            'tanggal'       => 'required|date',
            'keterangan'    => 'nullable|string',
            'bukti'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('bukti');

        if ($request->hasFile('bukti')) {
            if ($prestasi->bukti) Storage::disk('public')->delete($prestasi->bukti);
            $data['bukti'] = $request->file('bukti')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('guru-bk.prestasi.show', $prestasi)
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->bukti) Storage::disk('public')->delete($prestasi->bukti);
        $prestasi->delete();

        return redirect()->route('guru-bk.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }
}
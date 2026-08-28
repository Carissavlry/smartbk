<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\KonselingSesi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonselingController extends Controller
{
    // =====================
    // INDEX — Daftar Kasus
    // =====================
    public function index(Request $request)
    {
        $query = Konseling::with(['siswa', 'sesi'])
            ->where('guru_bk_id', Auth::id());

        if ($request->filled('siswa')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->siswa.'%')
                  ->orWhere('nis', 'like', '%'.$request->siswa.'%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $konselings = $query->latest()->paginate(10)->withQueryString();

        return view('guru-bk.konseling.index', compact('konselings'));
    }

    // =====================
    // CREATE — Form Kasus Baru
    // =====================
    public function create()
    {
        $siswas = User::role('siswa')
            ->whereHas('kelas', function($q) {
                $q->whereHas('guru', function($q2) {
                    $q2->where('id', Auth::id());
                });
            })
            ->orderBy('name')
            ->get();

        return view('guru-bk.konseling.create', compact('siswas'));
    }

    // =====================
    // STORE — Simpan Kasus + Sesi 1
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'          => 'required|exists:users,id',
            'kategori'          => 'required|in:Pribadi,Sosial,Belajar,Karir,Keluarga',
            'tanggal'           => 'required|date',
            'durasi'            => 'required|integer|min:1',
            'deskripsi_masalah' => 'required|string',
            'tindakan_konselor' => 'required|string',
            'rekomendasi'       => 'nullable|string',
            'tindak_lanjut'     => 'nullable|string',
        ]);

        // Simpan kasus utama
        $konseling = Konseling::create([
            'siswa_id'          => $request->siswa_id,
            'guru_bk_id'        => Auth::id(),
            'kategori'          => $request->kategori,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'status'            => 'baru',
        ]);

        // Simpan sesi pertama
        KonselingSesi::create([
            'konseling_id'      => $konseling->id,
            'ke'                => 1,
            'tanggal'           => $request->tanggal,
            'durasi'            => $request->durasi,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'tindakan_konselor' => $request->tindakan_konselor,
            'rekomendasi'       => $request->rekomendasi,
            'tindak_lanjut'     => $request->tindak_lanjut,
        ]);

        return redirect()->route('guru-bk.konseling.show', $konseling)
            ->with('success', 'Kasus konseling berhasil dicatat.');
    }

    // =====================
    // SHOW — Detail Kasus + Riwayat Sesi
    // =====================
    public function show(Konseling $konseling)
    {
        $konseling->load(['siswa.kelas', 'guruBk', 'sesi']);

        return view('guru-bk.konseling.show', compact('konseling'));
    }

    // =====================
    // EDIT — Form Edit Kasus
    // =====================
    public function edit(Konseling $konseling)
    {
        $siswas = User::role('siswa')
            ->whereHas('kelas', function($q) {
                $q->whereHas('guru', function($q2) {
                    $q2->where('id', Auth::id());
                });
            })
            ->orderBy('name')
            ->get();

        return view('guru-bk.konseling.edit', compact('konseling', 'siswas'));
    }

    // =====================
    // UPDATE — Update Kasus
    // =====================
    public function update(Request $request, Konseling $konseling)
    {
        $request->validate([
            'kategori'          => 'required|in:Pribadi,Sosial,Belajar,Karir,Keluarga',
            'deskripsi_masalah' => 'required|string',
        ]);

        $konseling->update([
            'kategori'          => $request->kategori,
            'deskripsi_masalah' => $request->deskripsi_masalah,
        ]);

        return redirect()->route('guru-bk.konseling.show', $konseling)
            ->with('success', 'Kasus konseling berhasil diperbarui.');
    }

    // =====================
    // UPDATE STATUS — Tombol langsung di Show
    // =====================
    public function updateStatus(Request $request, Konseling $konseling)
    {
        $request->validate([
            'status' => 'required|in:baru,dalam_proses,selesai',
        ]);

        $konseling->update(['status' => $request->status]);

        return back()->with('success', 'Status konseling berhasil diperbarui.');
    }

    // =====================
    // DESTROY — Hapus Kasus
    // =====================
    public function destroy(Konseling $konseling)
    {
        $konseling->delete();

        return redirect()->route('guru-bk.konseling.index')
            ->with('success', 'Kasus konseling berhasil dihapus.');
    }

    // =====================
    // SESI — Form Lanjut Konseling
    // =====================
    public function sesiCreate(Konseling $konseling)
    {
        $sesiKe = $konseling->sesi()->count() + 1;
        return view('guru-bk.konseling.sesi-create', compact('konseling', 'sesiKe'));
    }

    // =====================
    // SESI STORE — Simpan Sesi Baru
    // =====================
    public function sesiStore(Request $request, Konseling $konseling)
    {
        $request->validate([
            'tanggal'           => 'required|date',
            'durasi'            => 'required|integer|min:1',
            'deskripsi_masalah' => 'required|string',
            'tindakan_konselor' => 'required|string',
            'rekomendasi'       => 'nullable|string',
            'tindak_lanjut'     => 'nullable|string',
        ]);

        // Hitung sesi ke berapa
        $ke = $konseling->sesi()->count() + 1;

        KonselingSesi::create([
            'konseling_id'      => $konseling->id,
            'ke'                => $ke,
            'tanggal'           => $request->tanggal,
            'durasi'            => $request->durasi,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'tindakan_konselor' => $request->tindakan_konselor,
            'rekomendasi'       => $request->rekomendasi,
            'tindak_lanjut'     => $request->tindak_lanjut,
        ]);

        // Otomatis update status jadi dalam_proses
        if ($konseling->status === 'baru') {
            $konseling->update(['status' => 'dalam_proses']);
        }

        return redirect()->route('guru-bk.konseling.show', $konseling)
            ->with('success', 'Sesi konseling ke-'.$ke.' berhasil ditambahkan.');
    }

    // =====================
    // SESI SHOW — Detail 1 Sesi
    // =====================
    public function sesiShow(Konseling $konseling, KonselingSesi $sesi)
    {
        return view('guru-bk.konseling.sesi-show', compact('konseling', 'sesi'));
    }
}
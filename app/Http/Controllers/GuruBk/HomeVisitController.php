<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\HomeVisit;
use App\Models\HomeVisitFoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeVisitController extends Controller
{
    public function index(Request $request)
    {
        $guruBk   = Auth::user();
        $search   = $request->get('search');
        $kelas_id = $request->get('kelas_id');
        $tanggal  = $request->get('tanggal');

        $kelasList = \App\Models\Kelas::where('guru_id', $guruBk->id)->orderBy('nama')->get();

        $homeVisits = HomeVisit::where('guru_bk_id', $guruBk->id)
            ->with('siswa.kelas')
            ->when($search, function($q) use ($search) {
                $q->where(function($inner) use ($search) {
                    $inner->whereHas('siswa', fn($s) =>
                        $s->where('name', 'like', "%{$search}%")
                          ->orWhere('nis', 'like', "%{$search}%")
                    );
                });
            })
            ->when($kelas_id, fn($q) =>
                $q->whereHas('siswa', fn($s) => $s->where('kelas_id', $kelas_id))
            )
            ->when($tanggal, fn($q) => $q->whereDate('tanggal', $tanggal))
            ->latest('tanggal')
            ->paginate(15);

        return view('guru-bk.home-visit.index', compact(
            'homeVisits', 'search', 'kelas_id', 'tanggal', 'kelasList'
        ));
    }

    public function create()
    {
        $guruBk = Auth::user();
        $siswas = User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))
            ->whereHas('kelas', fn($q) => $q->where('guru_id', $guruBk->id))
            ->with('kelas')
            ->orderBy('name')
            ->get();

        $nomorSurat = HomeVisit::generateNomorSurat();

        return view('guru-bk.home-visit.create', compact('siswas', 'nomorSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'             => 'required|exists:users,id',
            'tanggal'              => 'required|date',
            'jam_mulai'            => 'required',
            'jam_selesai'          => 'required',
            'tujuan'               => 'required|string',
            'hasil'                => 'nullable|string',
            'kondisi_lingkungan'   => 'nullable|string',
            'kesimpulan'           => 'nullable|string',
            'rekomendasi'          => 'nullable|string',
            'tindak_lanjut'        => 'nullable|string',
            'status_kehadiran_ortu'=> 'required|in:Ada,Tidak Ada',
            'yang_menemani'        => 'nullable|string',
            'fotos'                => 'required|array|min:1|max:10',
            'fotos.*'              => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $homeVisit = HomeVisit::create([
            'nomor_surat'           => HomeVisit::generateNomorSurat(),
            'siswa_id'              => $request->siswa_id,
            'guru_bk_id'            => Auth::id(),
            'tanggal'               => $request->tanggal,
            'jam_mulai'             => $request->jam_mulai,
            'jam_selesai'           => $request->jam_selesai,
            'alamat'                => $request->alamat,
            'nama_ortu'             => $request->nama_ortu,
            'no_hp_ortu'            => $request->no_hp_ortu,
            'status_kehadiran_ortu' => $request->status_kehadiran_ortu,
            'yang_menemani'         => $request->yang_menemani,
            'tujuan'                => $request->tujuan,
            'hasil'                 => $request->hasil,
            'kondisi_lingkungan'    => $request->kondisi_lingkungan,
            'kesimpulan'            => $request->kesimpulan,
            'rekomendasi'           => $request->rekomendasi,
            'tindak_lanjut'         => $request->tindak_lanjut,
            'status'                => 'selesai',
        ]);

        // Upload foto
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('home-visit-fotos', 'public');
                HomeVisitFoto::create([
                    'home_visit_id' => $homeVisit->id,
                    'foto'          => $path,
                ]);
            }
        }

        return redirect()->route('guru-bk.home-visit.index')
            ->with('success', 'Data kunjungan rumah berhasil disimpan.');
    }

    public function show(HomeVisit $homeVisit)
    {
        $this->authorize_visit($homeVisit);
        $homeVisit->load('siswa.kelas', 'guruBk', 'fotos');
        return view('guru-bk.home-visit.show', compact('homeVisit'));
    }

    public function edit(HomeVisit $homeVisit)
    {
        $this->authorize_visit($homeVisit);
        $guruBk = Auth::user();
        $siswas = User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))
            ->whereHas('kelas', fn($q) => $q->where('guru_id', $guruBk->id))
            ->with('kelas')
            ->orderBy('name')
            ->get();

        $homeVisit->load('fotos');
        return view('guru-bk.home-visit.edit', compact('homeVisit', 'siswas'));
    }

    public function update(Request $request, HomeVisit $homeVisit)
    {
        $this->authorize_visit($homeVisit);
        $request->validate([
            'tanggal'              => 'required|date',
            'jam_mulai'            => 'required',
            'jam_selesai'          => 'required',
            'tujuan'               => 'required|string',
            'hasil'                => 'nullable|string',
            'kondisi_lingkungan'   => 'nullable|string',
            'kesimpulan'           => 'nullable|string',
            'rekomendasi'          => 'nullable|string',
            'tindak_lanjut'        => 'nullable|string',
            'status_kehadiran_ortu'=> 'required|in:Ada,Tidak Ada',
            'yang_menemani'        => 'nullable|string',
            'fotos'                => 'nullable|array|max:10',
            'fotos.*'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $homeVisit->update($request->only([
            'tanggal', 'jam_mulai', 'jam_selesai',
            'alamat', 'nama_ortu', 'no_hp_ortu',
            'status_kehadiran_ortu', 'yang_menemani',
            'tujuan', 'hasil', 'kondisi_lingkungan',
            'kesimpulan', 'rekomendasi', 'tindak_lanjut',
        ]));

        // Upload foto baru jika ada
        if ($request->hasFile('fotos')) {
            $existingCount = $homeVisit->fotos()->count();
            $newCount      = count($request->file('fotos'));

            if (($existingCount + $newCount) > 10) {
                return back()->withErrors(['fotos' => 'Total foto maksimal 10.']);
            }

            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('home-visit-fotos', 'public');
                HomeVisitFoto::create([
                    'home_visit_id' => $homeVisit->id,
                    'foto'          => $path,
                ]);
            }
        }

        return redirect()->route('guru-bk.home-visit.show', $homeVisit)
            ->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    public function destroy(HomeVisit $homeVisit)
    {
        $this->authorize_visit($homeVisit);

        // Hapus foto dari storage
        foreach ($homeVisit->fotos as $foto) {
            Storage::disk('public')->delete($foto->foto);
        }

        $homeVisit->delete();
        return redirect()->route('guru-bk.home-visit.index')
            ->with('success', 'Data kunjungan berhasil dihapus.');
    }

    public function destroyFoto(HomeVisitFoto $foto)
    {
        $homeVisit = $foto->homeVisit;
        $this->authorize_visit($homeVisit);

        if ($homeVisit->fotos()->count() <= 1) {
            return back()->withErrors(['foto' => 'Minimal harus ada 1 foto.']);
        }

        Storage::disk('public')->delete($foto->foto);
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    private function authorize_visit(HomeVisit $homeVisit)
    {
        if ($homeVisit->guru_bk_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
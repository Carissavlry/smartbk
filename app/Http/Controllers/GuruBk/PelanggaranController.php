<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\JenisPelanggaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ThresholdHelper;
use App\Models\Notification;
use App\Services\SuratPeringatanService;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $guruBk    = Auth::user();
        $search    = $request->get('siswa');
        $jenis     = $request->get('jenis');
        $thresholds = ThresholdHelper::getThresholds();

        $jenisList = \App\Models\JenisPelanggaran::orderBy('nama')->get();

        $pelanggarans = \App\Models\Pelanggaran::where('dicatat_oleh', $guruBk->id)
            ->with(['siswa', 'jenisPelanggaran'])
            ->when($search, fn($q) =>
                $q->whereHas('siswa', fn($s) =>
                    $s->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                )
            )
            ->when($jenis, fn($q) => $q->where('jenis_pelanggaran_id', $jenis))
            ->latest('tanggal')
            ->paginate(15);

        return view('guru-bk.pelanggaran.index', compact(
            'pelanggarans', 'jenisList', 'search', 'jenis', 'thresholds'
        ));
    }

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

        $jenisList = JenisPelanggaran::orderBy('nama')->get();

        return view('guru-bk.pelanggaran.create', compact('siswas', 'jenisList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'              => 'required|exists:users,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal'              => 'required|date',
            'poin'                 => 'required|integer|min:1',
            'keterangan'           => 'nullable|string|max:1000',
        ]);

        $pelanggaran = Pelanggaran::create([
            'user_id'              => $request->user_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tanggal'              => $request->tanggal,
            'poin'                 => $request->poin,
            'keterangan'           => $request->keterangan,
            'dicatat_oleh'         => Auth::id(),
        ]);

        // Notif langsung ke siswa setiap ada pencatatan pelanggaran baru
        $jenisPelanggaran = \App\Models\JenisPelanggaran::find($request->jenis_pelanggaran_id);
        $totalPoin = \App\Models\Pelanggaran::where('user_id', $request->user_id)->sum('poin');

        Notification::create([
            'user_id' => $request->user_id,
            'judul'   => 'Pelanggaran Baru Dicatat',
            'pesan'   => 'Kamu mendapat pelanggaran: ' . $jenisPelanggaran->nama . ' (+' . $request->poin . ' poin). Total poin kamu sekarang: ' . $totalPoin . ' poin.',
            'tipe'    => 'pelanggaran',
            'url'     => '/siswa/pelanggaran',
        ]);

        $this->cekDanKirimAlertThreshold($pelanggaran->user_id);

        return redirect()->route('guru-bk.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dicatat.');
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['siswa.kelas', 'jenisPelanggaran', 'pencatat']);

        $totalPoin = Pelanggaran::where('user_id', $pelanggaran->user_id)->sum('poin');

        return view('guru-bk.pelanggaran.show', compact('pelanggaran', 'totalPoin'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $siswas = User::role('siswa')
            ->whereHas('kelas', function($q) {
                $q->whereHas('guru', function($q2) {
                    $q2->where('id', Auth::id());
                });
            })
            ->orderBy('name')
            ->get();

        $jenisList = JenisPelanggaran::orderBy('nama')->get();

        return view('guru-bk.pelanggaran.edit', compact('pelanggaran', 'siswas', 'jenisList'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'user_id'              => 'required|exists:users,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal'              => 'required|date',
            'poin'                 => 'required|integer|min:1',
            'keterangan'           => 'nullable|string|max:1000',
        ]);

        $pelanggaran->update([
            'user_id'              => $request->user_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tanggal'              => $request->tanggal,
            'poin'                 => $request->poin,
            'keterangan'           => $request->keterangan,
        ]);

        $jenisPelanggaran = \App\Models\JenisPelanggaran::find($request->jenis_pelanggaran_id);
        $totalPoin = \App\Models\Pelanggaran::where('user_id', $request->user_id)->sum('poin');

        Notification::create([
            'user_id' => $request->user_id,
            'judul'   => 'Data Pelanggaran Diperbarui',
            'pesan'   => 'Data pelanggaran kamu diperbarui: ' . $jenisPelanggaran->nama . ' (' . $request->poin . ' poin). Total poin kamu sekarang: ' . $totalPoin . ' poin.',
            'tipe'    => 'pelanggaran',
            'url'     => '/siswa/pelanggaran',
        ]);

        $this->cekDanKirimAlertThreshold($pelanggaran->user_id);

        return redirect()->route('guru-bk.pelanggaran.show', $pelanggaran)
            ->with('success', 'Pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();

        return redirect()->route('guru-bk.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dihapus.');
    }

    private function cekDanKirimAlertThreshold(int $siswaId): void
    {
        $siswa      = User::find($siswaId);
        $totalPoin  = Pelanggaran::where('user_id', $siswaId)->sum('poin');
        $level      = ThresholdHelper::getLevel($totalPoin);
        $thresholds = ThresholdHelper::getThresholds();
        $guruBkId   = Auth::id();

        if ($level === 'aman') return;

        $labelLevel = match($level) {
            'kuning' => 'PERINGATAN (Kuning)',
            'merah'  => 'TINDAKAN DIPERLUKAN (Merah)',
            'hitam'  => 'STATUS KRITIS (Hitam)',
            default  => $level,
        };

        $batasLevel = match($level) {
            'kuning' => $thresholds['kuning'],
            'merah'  => $thresholds['merah'],
            'hitam'  => $thresholds['hitam'],
            default  => 0,
        };

        Notification::create([
            'user_id'               => $guruBkId,
            'judul'                 => "Alert Pelanggaran: {$siswa->name}",
            'pesan'                 => "Siswa {$siswa->name} telah mencapai {$totalPoin} poin pelanggaran. Status: {$labelLevel} (batas: {$batasLevel} poin). Segera lakukan tindak lanjut.",
            'tipe'                  => 'alert_pelanggaran',
            'url'                   => route('guru-bk.pelanggaran.index', ['siswa' => $siswa->name]),
            'total_poin_saat_alert' => $totalPoin,
        ]);

        // Auto-generate surat peringatan + kirim ke chat siswa
        // (Service punya anti-duplikat sendiri via cek level di DB)
        $guruBk  = User::find($guruBkId);
        $service = app(SuratPeringatanService::class);
        $service->checkAndGenerate($siswa, $guruBk);
    }
}
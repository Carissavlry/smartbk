<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\KonselingPengajuan;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonselingPengajuanController extends Controller
{
    // Daftar semua pengajuan masuk untuk Guru BK
    public function index(Request $request)
    {
        $gurubkId = Auth::id();

        $query = KonselingPengajuan::with(['siswa.kelas'])
            ->where('guru_bk_id', $gurubkId)
            ->latest();

        // Filter search nama/NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        $pengajuans = $query->paginate(15)->withQueryString();

        $totalMenunggu  = KonselingPengajuan::where('guru_bk_id', $gurubkId)->where('status', 'menunggu')->count();
        $totalDisetujui = KonselingPengajuan::where('guru_bk_id', $gurubkId)->where('status', 'disetujui')->count();
        $totalDitolak   = KonselingPengajuan::where('guru_bk_id', $gurubkId)->where('status', 'ditolak')->count();

        // Ambil kelas dari siswa yang pernah mengajukan ke guru BK ini
        // Ambil kelas binaan Guru BK (dari kolom guru_id di tabel kelas)
        $kelasList = \App\Models\Kelas::where('guru_id', $gurubkId)
            ->orderBy('nama')
            ->get();

        return view('guru-bk.konseling-pengajuan.index', compact(
            'pengajuans', 'totalMenunggu', 'totalDisetujui', 'totalDitolak', 'kelasList'
        ));
    }

    // Detail pengajuan
    public function show(KonselingPengajuan $konselingPengajuan)
    {
        $this->authorize_gurubk($konselingPengajuan);
        $konselingPengajuan->load('siswa', 'konseling');
        return view('guru-bk.konseling-pengajuan.show', compact('konselingPengajuan'));
    }

    // Setujui pengajuan
    public function setujui(KonselingPengajuan $konselingPengajuan)
    {
        $this->authorize_gurubk($konselingPengajuan);

        if ($konselingPengajuan->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($konselingPengajuan) {
            // Buat record konseling resmi
            $konseling = Konseling::create([
                'siswa_id'          => $konselingPengajuan->siswa_id,
                'guru_bk_id'        => $konselingPengajuan->guru_bk_id,
                'kategori'          => 'Pribadi',
                'deskripsi_masalah' => 'Dijadwalkan via pengajuan siswa. Topik: ' . $konselingPengajuan->topik,
                'status'            => 'Baru',
            ]);

            // Update status pengajuan
            $konselingPengajuan->update([
                'status'       => 'disetujui',
                'konseling_id' => $konseling->id,
            ]);

            // Kirim notifikasi ke siswa
            sendNotification(
                $konselingPengajuan->siswa_id,
                'Pengajuan Konseling Disetujui',
                'Pengajuan konseling kamu untuk topik "' . $konselingPengajuan->topik . '" telah disetujui. Jadwal: ' . \Carbon\Carbon::parse($konselingPengajuan->tanggal_diajukan)->format('d M Y') . ' pukul ' . $konselingPengajuan->jam_diajukan,
                'konseling',
                route('siswa.konseling.pengajuan.show', $konselingPengajuan->id)
            );
        });

        return redirect()->route('guru-bk.konseling-pengajuan.index')
            ->with('success', 'Pengajuan konseling berhasil disetujui.');
    }

    // Tolak pengajuan
    public function tolak(Request $request, KonselingPengajuan $konselingPengajuan)
    {
        $this->authorize_gurubk($konselingPengajuan);

        if ($konselingPengajuan->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $request->validate([
            'alasan_tolak' => 'required|string|min:5|max:500',
        ]);

        DB::transaction(function () use ($request, $konselingPengajuan) {
            $konselingPengajuan->update([
                'status'       => 'ditolak',
                'alasan_tolak' => $request->alasan_tolak,
            ]);

            sendNotification(
                $konselingPengajuan->siswa_id,
                'Pengajuan Konseling Ditolak',
                'Pengajuan konseling kamu untuk topik "' . $konselingPengajuan->topik . '" ditolak. Alasan: ' . $request->alasan_tolak,
                'konseling',
                route('siswa.konseling.pengajuan.show', $konselingPengajuan->id)
            );
        });

        return redirect()->route('guru-bk.konseling-pengajuan.index')
            ->with('success', 'Pengajuan konseling berhasil ditolak.');
    }

    // Reschedule pengajuan
    public function reschedule(Request $request, KonselingPengajuan $konselingPengajuan)
    {
        $this->authorize_gurubk($konselingPengajuan);

        if ($konselingPengajuan->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $request->validate([
            'tanggal_reschedule' => 'required|date|after_or_equal:today',
            'jam_reschedule'     => 'required',
            'catatan_reschedule' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $konselingPengajuan) {
            $konselingPengajuan->update([
                'status'             => 'reschedule',
                'tanggal_reschedule' => $request->tanggal_reschedule,
                'jam_reschedule'     => $request->jam_reschedule,
                'catatan_reschedule' => $request->catatan_reschedule,
            ]);

            sendNotification(
                $konselingPengajuan->siswa_id,
                'Jadwal Konseling Diubah',
                'Jadwal konseling kamu untuk topik "' . $konselingPengajuan->topik . '" diubah ke ' . \Carbon\Carbon::parse($request->tanggal_reschedule)->format('d M Y') . ' pukul ' . $request->jam_reschedule . '. ' . ($request->catatan_reschedule ?? ''),
                'konseling',
                route('siswa.konseling.pengajuan.show', $konselingPengajuan->id)
            );
        });

        return redirect()->route('guru-bk.konseling-pengajuan.index')
            ->with('success', 'Jadwal konseling berhasil direschedule.');
    }

    // Helper: pastikan Guru BK hanya akses pengajuan miliknya
    private function authorize_gurubk(KonselingPengajuan $pengajuan)
    {
        if ($pengajuan->guru_bk_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
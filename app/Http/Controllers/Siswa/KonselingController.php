<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\KonselingPengajuan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonselingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua data tanpa paginate dulu
        $konselings = Konseling::where('siswa_id', $userId)->latest()->get()->map(function($k) {
            $k->_type = 'konseling';
            return $k;
        });

        $pengajuanAll = KonselingPengajuan::where('siswa_id', $userId)->latest()->get()->map(function($p) {
            $p->_type = 'pengajuan';
            return $p;
        });

        // Gabung dan urutkan by created_at terbaru
        $merged = $konselings->concat($pengajuanAll)->sortByDesc('created_at')->values();

        // Paginate manual
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $total = $merged->count();
        $items = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $perPage, $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('siswa.konseling.index', compact('paginator', 'total'));
    }

    public function show(Konseling $konseling)
    {
        abort_if($konseling->siswa_id !== Auth::id(), 403);
        return view('siswa.konseling.show', compact('konseling'));
    }

    public function pengajuan()
    {
        $pengajuan = KonselingPengajuan::where('siswa_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('siswa.konseling.pengajuan', compact('pengajuan'));
    }

    public function showPengajuan(KonselingPengajuan $pengajuan)
    {
        abort_if($pengajuan->siswa_id !== Auth::id(), 403);
        return view('siswa.konseling.pengajuan_show', compact('pengajuan'));
    }

    public function storePengajuan(Request $request)
    {
        $request->validate([
            'topik'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_diajukan' => 'required|date|after_or_equal:today',
            'jam_diajukan'     => 'required',
        ]);

        // Cari guru BK yang menangani kelas siswa ini
        $user = Auth::user();
        $guruBkId = optional($user->kelas)->guru_id ?? null;

        $pengajuan = KonselingPengajuan::create([
            'siswa_id'        => $user->id,
            'guru_bk_id'      => $guruBkId,
            'topik'           => $request->topik,
            'deskripsi'       => $request->deskripsi,
            'tanggal_diajukan'=> $request->tanggal_diajukan,
            'jam_diajukan'    => $request->jam_diajukan,
            'status'          => 'menunggu',
        ]);

        // Kirim notifikasi ke Guru BK
        if ($guruBkId) {
            sendNotification(
                $guruBkId,
                'Pengajuan Konseling Baru',
                $user->name . ' mengajukan konseling untuk topik "' . $request->topik . '" pada ' .
                \Carbon\Carbon::parse($request->tanggal_diajukan)->format('d M Y') . ' pukul ' . $request->jam_diajukan,
                'konseling',
                route('guru-bk.konseling-pengajuan.show', $pengajuan->id)
            );
        }

        return redirect()->route('siswa.konseling.index')
            ->with('success', 'Pengajuan konseling berhasil dikirim!');
    }
}
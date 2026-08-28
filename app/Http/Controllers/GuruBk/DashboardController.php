<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use App\Helpers\ThresholdHelper;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guruBk = Auth::user();

        // Siswa binaan
        $siswaBinaan = \App\Models\User::whereHas('roles', function($q){
                $q->where('name', 'siswa');
            })
            ->whereHas('kelas', function($q) use ($guruBk){
                $q->where('guru_id', $guruBk->id);
            })
            ->count();

        // Konseling bulan ini (pakai created_at karena tidak ada kolom tanggal di konselings)
        $konselingBulanIni = Konseling::where('guru_bk_id', $guruBk->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Total konseling
        $totalKonseling = Konseling::where('guru_bk_id', $guruBk->id)->count();

        // Status konseling
        $konselingBaru   = Konseling::where('guru_bk_id', $guruBk->id)->where('status', 'Baru')->count();
        $konselingProses = Konseling::where('guru_bk_id', $guruBk->id)->where('status', 'Dalam Proses')->count();
        $konselingSelesai= Konseling::where('guru_bk_id', $guruBk->id)->where('status', 'Selesai')->count();

        // Konseling terbaru (5 data)
        $konselingTerbaru = Konseling::where('guru_bk_id', $guruBk->id)
            ->with('siswa')
            ->latest()
            ->take(5)
            ->get();

        // Statistik kategori
        $kategoriStats = Konseling::where('guru_bk_id', $guruBk->id)
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');
        // Siswa melewati threshold
        $thresholds = ThresholdHelper::getThresholds();

        $siswaIds = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))
            ->whereHas('kelas', fn($q) => $q->where('guru_id', $guruBk->id))
            ->pluck('id');

        $siswaThreshold = \App\Models\User::whereIn('id', $siswaIds)
            ->withSum('pelanggarans', 'poin')
            ->get()
            ->map(function($s) use ($thresholds) {
                $total = $s->pelanggarans_sum_poin ?? 0;
                return [
                    'siswa'      => $s,
                    'total_poin' => $total,
                    'level'      => ThresholdHelper::getLevel($total),
                ];
            })
            ->filter(fn($s) => $s['level'] !== 'aman')
            ->sortByDesc('total_poin')
            ->values();

        return view('guru-bk.dashboard', compact(
            'guruBk',
            'siswaBinaan',
            'konselingBulanIni',
            'totalKonseling',
            'konselingBaru',
            'konselingProses',
            'konselingSelesai',
            'konselingTerbaru',
            'kategoriStats',
            'siswaThreshold',
            'thresholds',
        ));
    }
}
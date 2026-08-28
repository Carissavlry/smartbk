<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\MutasiSiswa;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('admin_sekolah')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('guru_bk'))       return redirect()->route('guru-bk.dashboard');
        if ($user->hasRole('siswa'))         return redirect()->route('siswa.dashboard');
        abort(403, 'Role tidak dikenali.');
    }

    public function admin()
    {
        $totalSiswa    = \App\Models\User::role('siswa')->count();
        $totalGuru     = \App\Models\User::role('guru_bk')->count();
        $totalKelas    = Kelas::count();
        $tahunAjaran   = TahunAjaran::where('is_aktif', true)->first();

        // Statistik tambahan
        $totalMutasi       = MutasiSiswa::count();
        $mutasiMasuk       = MutasiSiswa::where('jenis_mutasi', 'masuk')->count();
        $mutasiKeluar      = MutasiSiswa::where('jenis_mutasi', 'keluar')->count();
        $mutasiInternal    = MutasiSiswa::where('jenis_mutasi', 'internal')->count();

        // Siswa per kelas
        $siswaPerKelas = Kelas::withCount(['siswas'])->get();

        // Mutasi terbaru
        $mutasiTerbaru = MutasiSiswa::with(['siswa', 'kelasAsal', 'kelasTujuan'])
            ->latest('tanggal_mutasi')
            ->take(5)
            ->get();

        // Log aktivitas terbaru
        $logTerbaru = ActivityLog::with('user')
            ->latest()
            ->take(7)
            ->get();

        // Siswa terbaru didaftarkan
        $siswaTerbaru = \App\Models\User::role('siswa')
            ->with('kelas')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'tahunAjaran',
            'totalMutasi', 'mutasiMasuk', 'mutasiKeluar', 'mutasiInternal',
            'siswaPerKelas', 'mutasiTerbaru', 'logTerbaru', 'siswaTerbaru'
        ));
    }

    public function guru()
    {
        return view('dashboard.guru');
    }

    public function siswa()
    {
        $user = Auth::user();

        // ===== KONSELING =====
        // konselings pakai siswa_id ✅
        $totalKonseling = \App\Models\Konseling::where('siswa_id', $user->id)->count();
        $konselings = \App\Models\Konseling::where('siswa_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // ===== PELANGGARAN =====
        // pelanggarans pakai user_id ✅
        $totalPoin = \App\Models\Pelanggaran::where('user_id', $user->id)->sum('poin');
        $pelanggaranTerbaru = \App\Models\Pelanggaran::with('jenisPelanggaran')
            ->where('user_id', $user->id)
            ->latest('tanggal')
            ->take(5)
            ->get();

        // ===== PRESTASI =====
        // prestasis pakai user_id ✅
        $totalPrestasi = \App\Models\Prestasi::where('user_id', $user->id)->count();
        $prestasiTerbaru = \App\Models\Prestasi::where('user_id', $user->id)
            ->latest('tanggal')
            ->take(3)
            ->get();

        // ===== PENGUMUMAN =====
        // tabel pengumuman, tidak ada is_aktif — pakai published_at ✅
        $pengumuman = \App\Models\Pengumuman::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(5)
            ->get();

        // ===== JADWAL KONSELING MENDATANG =====
        $jadwalMendatang = \App\Models\KonselingPengajuan::where('siswa_id', $user->id)
            ->where('status', 'disetujui')
            ->where('tanggal_diajukan', '>=', now()->toDateString())
            ->orderBy('tanggal_diajukan')
            ->take(3)
            ->get();

        // ===== NOTIFIKASI =====
        // notifications pakai user_id + read_at ✅
        $notifBelumDibaca = \App\Models\Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return view('dashboard.siswa', compact(
            'user',
            'konselings',
            'totalKonseling',
            'totalPoin',
            'pelanggaranTerbaru',
            'totalPrestasi',
            'prestasiTerbaru',
            'pengumuman',
            'jadwalMendatang',
            'notifBelumDibaca'
        ));
    }
}
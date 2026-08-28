<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $kelasId = $user->kelas_id;

        // Cari guru_bk yang menangani kelas siswa ini
        $guruBkId = \App\Models\Kelas::find($kelasId)?->guru_id;

        $pengumuman = Pengumuman::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function($q) use ($guruBkId) {
                // Tampilkan semua pengumuman target 'semua'
                $q->where('target', 'semua');
                // ATAU target kelas_binaan tapi hanya dari guru BK siswa ini
                if ($guruBkId) {
                    $q->orWhere(function($q2) use ($guruBkId) {
                        $q2->where('target', 'kelas_binaan')
                           ->where('guru_bk_id', $guruBkId);
                    });
                }
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('siswa.pengumuman.index', compact('pengumuman'));
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_if(is_null($pengumuman->published_at) || $pengumuman->published_at > now(), 404);

        $user    = Auth::user();
        $kelasId = $user->kelas_id;
        $guruBkId = \App\Models\Kelas::find($kelasId)?->guru_id;

        // Cek akses: semua boleh, kelas_binaan hanya dari guru BK sendiri
        if ($pengumuman->target === 'kelas_binaan' && $pengumuman->guru_bk_id !== $guruBkId) {
            abort(403);
        }

        return view('siswa.pengumuman.show', compact('pengumuman'));
    }
}
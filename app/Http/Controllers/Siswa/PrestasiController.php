<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $prestasis = Prestasi::where('user_id', $userId)
            ->latest('tanggal')
            ->paginate(10);

        // Summary cards
        $allPrestasi   = Prestasi::where('user_id', $userId)->get();
        $totalPrestasi = $allPrestasi->count();
        $akademik      = $allPrestasi->filter(fn($p) => $p->jenis === 'Akademik')->count();
        $nonAkademik   = $allPrestasi->filter(fn($p) => $p->jenis === 'Non-Akademik')->count();
        $juara1        = $allPrestasi->filter(fn($p) => $p->peringkat === 'Juara 1')->count();

        return view('siswa.prestasi.index', compact(
            'prestasis',
            'totalPrestasi',
            'akademik',
            'nonAkademik',
            'juara1'
        ));
    }
}
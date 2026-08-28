<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\SuratPeringatan;
use App\Models\User;
use App\Services\SuratPeringatanService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratPeringatanController extends Controller
{
    protected SuratPeringatanService $service;

    public function __construct(SuratPeringatanService $service)
    {
        $this->service = $service;
    }

    // List semua surat peringatan
    public function index(Request $request)
    {
        $query = SuratPeringatan::with(['siswa', 'guruBk'])
            ->orderByDesc('created_at');

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $surats = $query->paginate(15)->withQueryString();

        return view('guru-bk.surat-peringatan.index', compact('surats'));
    }

    // Detail surat
    public function show(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->load(['siswa', 'guruBk']);
        return view('guru-bk.surat-peringatan.show', compact('suratPeringatan'));
    }

    // Generate manual surat untuk siswa tertentu
    public function generate(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
        ]);

        $siswa  = User::findOrFail($request->siswa_id);
        $guruBk = auth()->user();

        $surat = $this->service->checkAndGenerate($siswa, $guruBk);

        if (!$surat) {
            return back()->with('info', 'Siswa belum mencapai threshold pelanggaran atau surat level ini sudah ada.');
        }

        return redirect()->route('guru-bk.surat-peringatan.show', $surat)
            ->with('success', 'Surat peringatan berhasil digenerate dan dikirim ke siswa.');
    }

    // Download PDF surat
    public function downloadPdf(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->load(['siswa', 'guruBk']);
        $setting = [
            'nama_sekolah' => setting('nama_sekolah'),
            'alamat_sekolah' => setting('alamat_sekolah'),
            'telp_sekolah'  => setting('telp_sekolah'),
            'kop_surat'     => setting('kop_surat'),
            'logo_sekolah'  => setting('logo_sekolah'),
        ];

        $pdf = Pdf::loadView('guru-bk.surat-peringatan.pdf', compact('suratPeringatan', 'setting'))
            ->setPaper('a4', 'portrait');

        $namaFile = 'Surat-Peringatan-' . str_replace('/', '-', $suratPeringatan->nomor_surat) . '.pdf';
        return $pdf->download($namaFile);
    }

    // Tandai surat sudah dibaca / diakui
    public function acknowledge(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->update(['status' => 'diakui']);
        return back()->with('success', 'Surat peringatan telah ditandai diakui.');
    }

    public function destroy(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->delete();
        return redirect()->route('guru-bk.surat-peringatan.index')
            ->with('success', 'Surat peringatan berhasil dihapus.');
    }
}
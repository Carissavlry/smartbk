<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\SuratPeringatan;
use Illuminate\Support\Facades\Auth;

class SuratPeringatanController extends Controller
{
    public function show(SuratPeringatan $suratPeringatan)
    {
        // Pastikan hanya pemilik surat yang bisa lihat
        abort_if($suratPeringatan->user_id !== Auth::id(), 403);

        $suratPeringatan->load(['guruBk']);

        // Tandai sudah diakui
        if ($suratPeringatan->status === 'terkirim') {
            $suratPeringatan->update(['status' => 'diakui']);
        }

        $setting = [
            'nama_sekolah'   => setting('nama_sekolah'),
            'alamat_sekolah' => setting('alamat_sekolah'),
        ];

        return view('siswa.surat-peringatan.show', compact('suratPeringatan', 'setting'));
    }

    public function download(SuratPeringatan $suratPeringatan)
    {
        abort_if($suratPeringatan->user_id !== Auth::id(), 403);

        $suratPeringatan->load(['guruBk', 'siswa']);

        $setting = [
            'nama_sekolah'   => setting('nama_sekolah'),
            'alamat_sekolah' => setting('alamat_sekolah'),
            'telp_sekolah'   => setting('telp_sekolah'),
            'kop_surat'      => setting('kop_surat'),
            'logo_sekolah'   => setting('logo_sekolah'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('guru-bk.surat-peringatan.pdf', compact('suratPeringatan', 'setting'))
            ->setPaper('a4', 'portrait');

        $namaFile = 'Surat-Peringatan-' . str_replace('/', '-', $suratPeringatan->nomor_surat) . '.pdf';

        return $pdf->download($namaFile);
    }
}
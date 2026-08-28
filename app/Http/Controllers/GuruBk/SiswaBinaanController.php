<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Setting;

class SiswaBinaanController extends Controller
{
    public function index()
    {
        $guruBk = Auth::user();

        $siswas = User::whereHas('roles', function($q) {
                $q->where('name', 'siswa');
            })
            ->whereHas('kelas', function($q) use ($guruBk) {
                $q->where('guru_id', $guruBk->id);
            })
            ->with(['kelas', 'pelanggarans'])
            ->when(request('search'), function($q) {
                $q->where(function($q) {
                    $q->where('name', 'like', '%'.request('search').'%')
                      ->orWhere('nis', 'like', '%'.request('search').'%');
                });
            })
            ->when(request('kelas_id'), function($q) {
                $q->where('kelas_id', request('kelas_id'));
            })
            ->orderBy('name')
            ->paginate(15);

        // Daftar kelas binaan untuk filter
        $kelasBinaan = \App\Models\Kelas::where('guru_id', $guruBk->id)->get();

        return view('guru-bk.siswa-binaan.index', compact('siswas', 'kelasBinaan'));
    }

    public function show(User $siswa)
    {
        $guruBk = Auth::user();

        // Pastikan siswa ini memang binaan guru BK ini
        $kelasIds = \App\Models\Kelas::where('guru_id', $guruBk->id)->pluck('id');
        if (!in_array($siswa->kelas_id, $kelasIds->toArray())) {
            abort(403, 'Siswa ini bukan binaan Anda.');
        }

        $siswa->load('kelas');

        // Riwayat konseling
        $konselings = Konseling::where('siswa_id', $siswa->id)
            ->with('sesi')
            ->latest()
            ->get();

        $pelanggarans = Pelanggaran::where('user_id', $siswa->id)
            ->with('jenisPelanggaran')
            ->latest()
            ->get();

        // Total poin pelanggaran
        $totalPoin = $pelanggarans->sum('poin');

        return view('guru-bk.siswa-binaan.show', compact(
            'siswa',
            'konselings',
            'pelanggarans',
            'totalPoin'
        ));
    }

    public function kartu(User $siswa)
    {
        $guruBk = Auth::user();
        $kelasIds = \App\Models\Kelas::where('guru_id', $guruBk->id)->pluck('id');
        if (!in_array($siswa->kelas_id, $kelasIds->toArray())) {
            abort(403, 'Siswa ini bukan binaan Anda.');
        }

        $qrCode = QrCode::format('svg')
            ->size(100)
            ->generate(route('guru-bk.siswa-binaan.show', $siswa));

        $config = (object)[
            'nama_sekolah'   => Setting::get('nama_sekolah', 'SmartBK'),
            'alamat_sekolah' => Setting::get('alamat_sekolah', 'Sistem Informasi Bimbingan Konseling'),
            'logo'           => Setting::get('logo_sekolah', null),
        ];

        return view('admin.siswa.kartu', compact('siswa', 'qrCode', 'config'));
    }
}
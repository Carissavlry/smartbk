<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with('jenisPelanggaran')
            ->where('user_id', Auth::id())
            ->latest('tanggal')
            ->paginate(10);

        $totalPoin = Pelanggaran::where('user_id', Auth::id())->sum('poin');

        return view('siswa.pelanggaran.index', compact('pelanggarans', 'totalPoin'));
    }
}
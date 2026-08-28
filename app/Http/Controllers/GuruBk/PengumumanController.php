<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('guru_bk_id', Auth::id())
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('guru-bk.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('guru-bk.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|in:pribadi_sosial,belajar,karir,info_umum',
            'target'   => 'required|in:semua,kelas_binaan',
        ]);

        Pengumuman::create([
            'guru_bk_id'   => Auth::id(),
            'judul'        => $request->judul,
            'isi'          => $request->isi,
            'kategori'     => $request->kategori,
            'target'       => $request->target,
            'is_pinned'    => $request->boolean('is_pinned'),
            'published_at' => now(),
        ]);

        return redirect()->route('guru-bk.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        abort_if($pengumuman->guru_bk_id !== Auth::id(), 403);
        return view('guru-bk.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        abort_if($pengumuman->guru_bk_id !== Auth::id(), 403);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|in:pribadi_sosial,belajar,karir,info_umum',
            'target'   => 'required|in:semua,kelas_binaan',
        ]);

        $pengumuman->update([
            'judul'     => $request->judul,
            'isi'       => $request->isi,
            'kategori'  => $request->kategori,
            'target'    => $request->target,
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('guru-bk.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        abort_if($pengumuman->guru_bk_id !== Auth::id(), 403);
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function togglePin(Pengumuman $pengumuman)
    {
        abort_if($pengumuman->guru_bk_id !== Auth::id(), 403);
        $pengumuman->update(['is_pinned' => !$pengumuman->is_pinned]);

        return back()->with('success', $pengumuman->is_pinned ? 'Pengumuman dipinned.' : 'Pin dilepas.');
    }
}
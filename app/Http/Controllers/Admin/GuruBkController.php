<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class GuruBkController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('guru_bk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->status === 'assigned') {
            $query->whereHas('kelasBindaan');
        } elseif ($request->status === 'unassigned') {
            $query->whereDoesntHave('kelasBindaan');
        }

        $gurubks = $query->with('kelasBindaan')->orderBy('name')->get();

        return view('admin.guru-bk.index', compact('gurubks'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        return view('admin.guru-bk.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'nip'           => 'required|string|max:20|unique:users,nip',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp'         => 'nullable|string|max:20|unique:users,no_hp',
            'email'         => 'nullable|email|unique:users,email',
            'kelas_ids'     => 'nullable|array',
            'kelas_ids.*'   => 'exists:kelas,id',
        ], [
            'nip.unique'   => 'NIP sudah digunakan oleh guru lain.',
            'no_hp.unique' => 'No HP sudah digunakan oleh guru lain.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $guru = User::create([
            'name'                 => $request->name,
            'nip'                  => $request->nip,
            'jenis_kelamin'        => $request->jenis_kelamin,
            'no_hp'                => $request->no_hp,
            'email'                => $request->email,
            'pendidikan_terakhir'  => $request->pendidikan_terakhir,
            'tahun_mulai_bertugas' => $request->tahun_mulai_bertugas,
            'password'             => Hash::make('gurubk123'),
            'is_first_login'       => true,
        ]);

        $guru->assignRole('guru_bk');

        if ($request->filled('kelas_ids')) {
            Kelas::whereIn('id', $request->kelas_ids)
                 ->update(['guru_id' => $guru->id]);
        }

        ActivityLog::record('CREATE', 'Guru BK', "Menambah Guru BK: {$guru->name} (NIP: {$guru->nip})", $guru);

        return redirect()->route('admin.guru-bk.index')
                         ->with('success', 'Akun Guru BK berhasil ditambahkan. Password default: gurubk123');
    }

    public function edit(User $gurubk)
    {
        abort_if(!$gurubk->hasRole('guru_bk'), 403);

        $kelasList    = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        $kelasBindaan = Kelas::where('guru_id', $gurubk->id)->pluck('id')->toArray();
        $guru         = $gurubk;

        return view('admin.guru-bk.edit', compact('guru', 'kelasList', 'kelasBindaan'));
    }

    public function update(Request $request, User $gurubk)
    {
        abort_if(!$gurubk->hasRole('guru_bk'), 403);

        $request->validate([
            'name'          => 'required|string|max:100',
            'nip'           => 'required|string|max:20|unique:users,nip,' . $gurubk->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp'         => 'nullable|string|max:20|unique:users,no_hp,' . $gurubk->id,
            'email'         => 'nullable|email|unique:users,email,' . $gurubk->id,
            'kelas_ids'     => 'nullable|array',
            'kelas_ids.*'   => 'exists:kelas,id',
        ], [
            'nip.unique'   => 'NIP sudah digunakan oleh guru lain.',
            'no_hp.unique' => 'No HP sudah digunakan oleh guru lain.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $data = [
            'name'                 => $request->name,
            'nip'                  => $request->nip,
            'jenis_kelamin'        => $request->jenis_kelamin,
            'no_hp'                => $request->no_hp,
            'pendidikan_terakhir'  => $request->pendidikan_terakhir,
            'tahun_mulai_bertugas' => $request->tahun_mulai_bertugas,
        ];

        if ($request->filled('password')) {
            $data['password']       = Hash::make($request->password);
            $data['is_first_login'] = true;
        }

        $gurubk->update($data);

        Kelas::where('guru_id', $gurubk->id)->update(['guru_id' => null]);
        if ($request->filled('kelas_ids')) {
            Kelas::whereIn('id', $request->kelas_ids)
                 ->update(['guru_id' => $gurubk->id]);
        }

        ActivityLog::record('UPDATE', 'Guru BK', "Mengubah data Guru BK: {$gurubk->name} (NIP: {$gurubk->nip})", $gurubk);

        return redirect()->route('admin.guru-bk.index')
                         ->with('success', 'Data Guru BK berhasil diperbarui.');
    }

    public function destroy(User $gurubk)
    {
        abort_if(!$gurubk->hasRole('guru_bk'), 403);

        $nama = $gurubk->name;
        $nip  = $gurubk->nip;

        Kelas::where('guru_id', $gurubk->id)->update(['guru_id' => null]);
        $gurubk->delete();

        ActivityLog::record('DELETE', 'Guru BK', "Menghapus Guru BK: {$nama} (NIP: {$nip})");

        return redirect()->route('admin.guru-bk.index')
                         ->with('success', 'Akun Guru BK berhasil dihapus.');
    }

    public function resetPassword(User $gurubk)
    {
        abort_if(!$gurubk->hasRole('guru_bk'), 403);

        $gurubk->update([
            'password'       => Hash::make('gurubk123'),
            'is_first_login' => true,
        ]);

        ActivityLog::record('UPDATE', 'Guru BK', "Reset password Guru BK: {$gurubk->name} (NIP: {$gurubk->nip})", $gurubk);

        return redirect()->route('admin.guru-bk.index')
                         ->with('success', "Password {$gurubk->name} berhasil direset ke: gurubk123");
    }
}
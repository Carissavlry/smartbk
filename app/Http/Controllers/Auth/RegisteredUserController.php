<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('auth.register', compact('kelasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role'     => 'required|in:siswa,guru_bk',
            'name'     => 'required|string|max:100',
            'email'    => 'nullable|email|unique:users,email',
            'nis'      => 'required_if:role,siswa|nullable|string|max:20|unique:users,nis',
            'kelas_id' => 'required_if:role,siswa|nullable|exists:kelas,id',
            'nip'      => 'required_if:role,guru_bk|nullable|string|max:30|unique:users,nip',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'nis'            => $request->role === 'siswa' ? $request->nis : null,
            'kelas_id'       => $request->role === 'siswa' ? $request->kelas_id : null,
            'nip'            => $request->role === 'guru_bk' ? $request->nip : null,
            'password'       => Hash::make($request->password),
            'status'         => 'pending',
            'is_first_login' => true,
        ]);

        $user->assignRole($request->role);

        ActivityLog::record('REGISTER', 'Auth', "Pendaftaran akun baru ({$request->role}): {$user->name}, menunggu approval admin", $user);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun kamu menunggu persetujuan Admin sebelum bisa login.');
    }
}
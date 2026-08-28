<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class FirstLoginController extends Controller
{
    // Tampilkan form ganti password
    public function create()
    {
        return view('auth.first-login');
    }

    // Proses ganti password
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed|regex:/[0-9]/',
        ], [
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex'     => 'Password harus mengandung minimal 1 angka.',
        ]);

        $user = Auth::user();

        $user->update([
            'password'       => Hash::make($request->password),
            'is_first_login' => false,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Password berhasil diubah. Selamat datang di SmartBK!');
    }
}
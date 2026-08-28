<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // Redirect ke Google — mode LOGIN biasa
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // Redirect ke Google — mode CONNECT (user sudah login)
    public function connectRedirect()
    {
        // Encode user_id + role ke dalam state parameter Google OAuth
        $state = base64_encode(json_encode([
            'mode'    => 'connect',
            'user_id' => Auth::id(),
            'role'    => Auth::user()->getRoleNames()->first(),
        ]));

        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',
                'state'  => $state,
            ])
            ->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        // Cek state parameter dari Google
        $stateRaw = request('state');
        $state    = null;

        if ($stateRaw) {
            try {
                $decoded = json_decode(base64_decode($stateRaw), true);
                if (isset($decoded['mode']) && $decoded['mode'] === 'connect') {
                    $state = $decoded;
                }
            } catch (\Exception $e) {
                $state = null;
            }
        }

        // Ambil user Google — pakai stateless agar tidak konflik session
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            if ($state) {
                $route = $state['role'] === 'guru_bk' ? 'guru-bk.profil.index' : 'siswa.profil.index';
                return redirect()->route($route)
                    ->with('error', 'Gagal menghubungkan akun Google. Coba lagi.');
            }
            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google gagal. Silakan coba lagi.']);
        }

        // ===== MODE CONNECT =====
        if ($state) {
            return $this->handleConnect($googleUser, $state);
        }

        // ===== MODE LOGIN BIASA =====
        $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Google ini tidak terdaftar di sistem. Hubungi Admin Sekolah.']);
        }

        if (!$user->google_id) {
            $user->google_id = $googleUser->getId();
            $user->save();
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // Handle CONNECT akun Google ke akun yang sudah login
    private function handleConnect($googleUser, $state)
    {
        $userId = $state['user_id'];
        $role   = $state['role'];

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // Cek apakah google_id sudah dipakai user lain
        $existing = User::where('google_id', $googleUser->getId())
                        ->where('id', '!=', $user->id)
                        ->first();

        if ($existing) {
            $route = $role === 'guru_bk' ? 'guru-bk.profil.index' : 'siswa.profil.index';
            return redirect()->route($route)
                ->with('error', 'Akun Google ini sudah terhubung ke akun lain.');
        }

        // Simpan google_id + google_email
        $user->google_id    = $googleUser->getId();
        $user->google_email = $googleUser->getEmail();

        // Jika email user kosong, isi otomatis dari Google
        if (empty($user->email)) {
            $user->email = $googleUser->getEmail();
        }

        $user->save();

        $route = $role === 'guru_bk' ? 'guru-bk.profil.index' : 'siswa.profil.index';

        // Login ulang SETELAH tentukan route & flash
        Auth::login($user);

        session()->flash('success_google', 'Akun Google (' . $googleUser->getEmail() . ') berhasil dihubungkan! Anda sekarang bisa login menggunakan NIP atau Google.');

        return redirect()->route($route);
    }
}
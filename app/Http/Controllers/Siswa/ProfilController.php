<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('kelas');
        $totalKonseling   = $user->konselings()->count();
        $totalPelanggaran = $user->pelanggarans()->count();
        $totalPoin        = $user->pelanggarans()->sum('poin');
        $totalPrestasi    = $user->prestasis()->count();
        return view('siswa.profil.index', compact(
            'user',
            'totalKonseling',
            'totalPelanggaran',
            'totalPoin',
            'totalPrestasi'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|unique:users,email,' . $user->id,
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string|max:500',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'nama_ortu'     => 'nullable|string|max:255',
            'no_hp_ortu'    => 'nullable|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->no_hp         = $request->no_hp;
        $user->alamat        = $request->alamat;
        $user->tempat_lahir  = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->nama_ortu     = $request->nama_ortu;
        $user->no_hp_ortu    = $request->no_hp_ortu;

        if ($request->hasFile('foto')) {
            if ($user->foto && file_exists(public_path('storage/' . $user->foto))) {
                unlink(public_path('storage/' . $user->foto));
            }
            $path       = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function password(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success_password', 'Password berhasil diubah!');
    }

    public function googleConnect()
    {
        return redirect()->route('auth.google.connect');
    }

    public function googleDisconnect()
    {
        $user = Auth::user();
        $user->google_id    = null;
        $user->google_email = null;
        $user->email        = null;
        $user->save();

        return back()->with('success', 'Akun Google berhasil diputuskan. Email kamu telah dikosongkan.');
    }
}
<?php
namespace App\Http\Controllers\GuruBK;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $kelas = \App\Models\Kelas::where('guru_id', $user->id)->get();
        $totalKonseling   = \App\Models\Konseling::where('guru_bk_id', $user->id)->count();
        $totalPelanggaran = \App\Models\Pelanggaran::where('dicatat_oleh', $user->id)->count();
        $totalHomeVisit   = \App\Models\HomeVisit::where('guru_bk_id', $user->id)->count();
        return view('guru-bk.profil.index', compact(
            'user',
            'kelas',
            'totalKonseling',
            'totalPelanggaran',
            'totalHomeVisit'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'nullable|email|unique:users,email,' . $user->id,
            'no_hp'                => 'nullable|string|max:20',
            'pendidikan_terakhir'  => 'nullable|string|max:100',
            'tahun_mulai_bertugas' => 'nullable|digits:4|integer',
            'foto'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->no_hp                = $request->no_hp;
        $user->pendidikan_terakhir  = $request->pendidikan_terakhir;
        $user->tahun_mulai_bertugas = $request->tahun_mulai_bertugas;

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
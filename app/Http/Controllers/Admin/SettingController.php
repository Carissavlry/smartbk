<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'nama_sekolah'      => Setting::get('nama_sekolah', ''),
            'alamat_sekolah'    => Setting::get('alamat_sekolah', ''),
            'telp_sekolah'      => Setting::get('telp_sekolah', ''),
            'email_sekolah'     => Setting::get('email_sekolah', ''),
            'logo_sekolah'      => Setting::get('logo_sekolah', ''),
            'threshold_kuning'  => Setting::get('threshold_kuning', 25),
            'threshold_merah'   => Setting::get('threshold_merah', 50),
            'threshold_hitam'   => Setting::get('threshold_hitam', 75),
            'kop_surat'         => Setting::get('kop_surat', ''),
        ];

        return view('admin.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'      => 'required|string|max:255',
            'alamat_sekolah'    => 'nullable|string|max:500',
            'telp_sekolah'      => 'nullable|string|max:20',
            'email_sekolah'     => 'nullable|email|max:255',
            'logo_sekolah'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'threshold_kuning'  => 'required|integer|min:1|max:100',
            'threshold_merah'   => 'required|integer|min:1|max:100',
            'threshold_hitam'   => 'required|integer|min:1|max:100',
            'kop_surat'         => 'nullable|string|max:1000',
        ]);

        // Simpan logo jika ada upload baru
        if ($request->hasFile('logo_sekolah')) {
            $oldLogo = Setting::get('logo_sekolah');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('logo_sekolah')->store('logo', 'public');
            Setting::set('logo_sekolah', $logoPath);
        }

        // Simpan semua setting
        Setting::set('nama_sekolah',     $request->nama_sekolah);
        Setting::set('alamat_sekolah',   $request->alamat_sekolah);
        Setting::set('telp_sekolah',     $request->telp_sekolah);
        Setting::set('email_sekolah',    $request->email_sekolah);
        Setting::set('threshold_kuning', $request->threshold_kuning);
        Setting::set('threshold_merah',  $request->threshold_merah);
        Setting::set('threshold_hitam',  $request->threshold_hitam);
        Setting::set('kop_surat',        $request->kop_surat);

        ActivityLog::record('UPDATE', 'Konfigurasi', 'Mengubah konfigurasi sistem');

        return redirect()->route('admin.setting.index')
                         ->with('success', 'Konfigurasi sistem berhasil disimpan.');
    }
}
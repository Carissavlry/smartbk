@extends('layouts.siswa')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    <div style="margin-bottom:24px;">
        <h1 style="font-size:1.4rem;font-weight:800;color:#0f172a;margin:0;">Profil Saya</h1>
        <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Kelola informasi pribadi dan keamanan akun kamu</p>
    </div>

    @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.85rem;color:#15803d;font-weight:600;">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('success_password'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.85rem;color:#15803d;font-weight:600;">{{ session('success_password') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.85rem;color:#dc2626;font-weight:600;">{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->has('password') || $errors->has('current_password'))
    <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.85rem;color:#dc2626;font-weight:600;">
            @if($errors->has('current_password'))
                {{ $errors->first('current_password') }}
            @else
                {{ $errors->first('password') }}
            @endif
        </span>
    </div>
    @endif

    <div style="display:grid;grid-template-columns:320px 1fr;gap:24px;align-items:start;">

        {{-- KOLOM KIRI --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- Kartu Foto & Info --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#1e3a5f,#6b1d1d);padding:28px 24px;text-align:center;">
                    @if($user->foto)
                        <img src="{{ asset('storage/'.$user->foto) }}"
                             style="width:88px;height:88px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.4);margin:0 auto 12px;display:block;">
                    @else
                        <div style="width:88px;height:88px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;border:3px solid rgba(255,255,255,0.3);">
                            <span style="font-size:2rem;font-weight:800;color:white;">{{ strtoupper(substr($user->name,0,1)) }}</span>
                        </div>
                    @endif
                    <p style="font-size:1rem;font-weight:800;color:white;margin:0;">{{ $user->name }}</p>
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.75);margin:4px 0 0;">NIS: {{ $user->nis ?? '-' }}</p>
                    <span style="display:inline-block;margin-top:8px;background:rgba(255,255,255,0.2);color:white;font-size:0.72rem;font-weight:700;padding:3px 12px;border-radius:20px;border:1px solid rgba(255,255,255,0.3);">Siswa</span>
                </div>
                <div style="padding:18px 20px;display:flex;flex-direction:column;gap:10px;">
                    @foreach([
                        ['Kelas',       $user->kelas->nama_kelas ?? '-'],
                        ['Email',       Str::limit($user->email ?? '-', 22)],
                        ['No. HP',      $user->no_hp ?? '-'],
                        ['Tempat Lahir',$user->tempat_lahir ?? '-'],
                        ['Tgl. Lahir',  $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : '-'],
                        ['Nama Ortu',   $user->nama_ortu ?? '-'],
                        ['HP Ortu',     $user->no_hp_ortu ?? '-'],
                    ] as [$label, $val])
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#f8fafc;border-radius:8px;">
                        <span style="font-size:0.75rem;color:#64748b;">{{ $label }}</span>
                        <span style="font-size:0.78rem;font-weight:600;color:#0f172a;">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Statistik --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
                <p style="font-size:0.8rem;font-weight:700;color:#374151;margin:0 0 14px;">Ringkasan Aktivitas</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div style="text-align:center;padding:12px 8px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:10px;border:1px solid #bfdbfe;">
                        <p style="font-size:1.5rem;font-weight:800;color:#1d4ed8;margin:0;">{{ $totalKonseling }}</p>
                        <p style="font-size:0.68rem;color:#3b82f6;margin:2px 0 0;font-weight:600;">Konseling</p>
                    </div>
                    <div style="text-align:center;padding:12px 8px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:10px;border:1px solid #fcd34d;">
                        <p style="font-size:1.5rem;font-weight:800;color:#d97706;margin:0;">{{ $totalPoin }}</p>
                        <p style="font-size:0.68rem;color:#d97706;margin:2px 0 0;font-weight:600;">Poin Pelanggaran</p>
                    </div>
                    <div style="text-align:center;padding:12px 8px;background:linear-gradient(135deg,#fce7f3,#fbcfe8);border-radius:10px;border:1px solid #f9a8d4;">
                        <p style="font-size:1.5rem;font-weight:800;color:#be185d;margin:0;">{{ $totalPelanggaran }}</p>
                        <p style="font-size:0.68rem;color:#be185d;margin:2px 0 0;font-weight:600;">Pelanggaran</p>
                    </div>
                    <div style="text-align:center;padding:12px 8px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-radius:10px;border:1px solid #86efac;">
                        <p style="font-size:1.5rem;font-weight:800;color:#15803d;margin:0;">{{ $totalPrestasi }}</p>
                        <p style="font-size:0.68rem;color:#15803d;margin:2px 0 0;font-weight:600;">Prestasi</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- FORM EDIT PROFIL --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
                <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);display:flex;align-items:center;justify-content:center;">
                        <svg style="width:16px;height:16px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span style="font-size:0.9rem;font-weight:700;color:#0f172a;">Edit Informasi Pribadi</span>
                </div>
                <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data" style="padding:24px;">
                    @csrf
                    @method('PUT')
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Nama Lengkap <span style="color:#dc2626;">*</span></label>
                            <input type="text" name="name" value="{{ old('name',$user->name) }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('name')<p style="font-size:0.72rem;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Email <span style="color:#dc2626;">*</span></label>
                            <input type="email" name="email" value="{{ old('email',$user->email) }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('email')<p style="font-size:0.72rem;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">No. HP / WA</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp',$user->no_hp ?? '') }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                placeholder="08xxxxxxxxxx"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir',$user->tempat_lahir ?? '') }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                placeholder="Contoh: Surabaya"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : '') }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Nama Orang Tua</label>
                            <input type="text" name="nama_ortu" value="{{ old('nama_ortu',$user->nama_ortu ?? '') }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                placeholder="Nama ayah/ibu"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">No. HP Orang Tua</label>
                            <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu',$user->no_hp_ortu ?? '') }}"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                placeholder="08xxxxxxxxxx"
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Foto Profil</label>
                            <input type="file" name="foto" accept="image/*"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.82rem;color:#475569;background:#f8fafc;box-sizing:border-box;">
                            <p style="font-size:0.7rem;color:#94a3b8;margin-top:4px;">Format: JPG, PNG, maks. 2MB</p>
                        </div>

                        {{-- READ ONLY --}}
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">NIS</label>
                            <input type="text" value="{{ $user->nis ?? '-' }}" disabled
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#94a3b8;background:#f8fafc;box-sizing:border-box;cursor:not-allowed;">
                            <p style="font-size:0.7rem;color:#94a3b8;margin-top:4px;">NIS tidak dapat diubah</p>
                        </div>

                        <div style="grid-column:1/-1;">
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Alamat</label>
                            <textarea name="alamat" rows="3"
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;resize:vertical;box-sizing:border-box;"
                                placeholder="Alamat lengkap..."
                                onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">{{ old('alamat',$user->alamat ?? '') }}</textarea>
                        </div>

                    </div>
                    <div style="margin-top:20px;display:flex;justify-content:flex-end;">
                        <button type="submit"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);color:white;padding:10px 24px;border-radius:10px;border:none;font-size:0.85rem;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(30,58,95,0.3);"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- HUBUNGKAN GOOGLE --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
                <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                    </div>
                    <span style="font-size:0.9rem;font-weight:700;color:#0f172a;">Hubungkan Google</span>
                </div>
                <div style="padding:20px 24px;">
                    @if($user->google_id)
                        @if(session('success_google'))
                            <div style="display:flex;align-items:flex-start;gap:10px;padding:14px 16px;background:#f0fdf4;border:1px solid #86efac;border-radius:10px;margin-bottom:16px;">
                                <svg style="width:20px;height:20px;flex-shrink:0;margin-top:1px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span style="font-size:0.85rem;color:#15803d;font-weight:600;">{{ session('success_google') }}</span>
                            </div>
                        @else
                            <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;background:#f0fdf4;border:1px solid #86efac;border-radius:10px;margin-bottom:8px;">
                                <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p style="font-size:0.85rem;color:#15803d;font-weight:700;margin:0;">Akun Google sudah terhubung</p>
                                    <p style="font-size:0.8rem;color:#16a34a;margin:2px 0 0 0;">{{ $user->google_email ?? '' }}</p>
                                </div>
                            </div>
                        @endif
                        <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;margin-bottom:14px;">
                            <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span style="font-size:0.78rem;color:#1d4ed8;">Kamu dapat login menggunakan <strong>NIS</strong> atau <strong>Akun Google</strong></span>
                        </div>
                        <form method="POST" action="{{ route('siswa.profil.google.disconnect') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="width:100%;padding:10px;background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;border-radius:10px;font-size:0.85rem;font-weight:700;cursor:pointer;"
                                onclick="return confirm('Yakin ingin memutuskan akun Google?')"
                                onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                Putuskan Akun Google
                            </button>
                        </form>
                    @else
                        <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:14px;">
                            <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <div>
                                <p style="font-size:0.85rem;color:#475569;font-weight:600;margin:0;">Akun Google belum terhubung</p>
                                <p style="font-size:0.78rem;color:#94a3b8;margin:2px 0 0 0;">Hubungkan untuk bisa login lebih mudah</p>
                            </div>
                        </div>
                        <a href="{{ route('auth.google.connect') }}"
                            style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:10px;background:white;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;font-weight:700;color:#374151;text-decoration:none;box-sizing:border-box;"
                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <svg style="width:18px;height:18px;" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Hubungkan dengan Google
                        </a>
                    @endif
                </div>
            </div>

            {{-- FORM GANTI PASSWORD --}}
            <div id="section-password" style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
                <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:17px;height:17px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <span style="font-size:0.9rem;font-weight:700;color:#0f172a;">Ganti Password</span>
                </div>
                <form method="POST" action="{{ route('siswa.profil.password') }}" style="padding:24px;">
                    @csrf
                    @method('PUT')
                    <div style="display:flex;flex-direction:column;gap:14px;">

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Password Lama <span style="color:#dc2626;">*</span></label>
                            <div style="position:relative;">
                                <input type="password" name="current_password" id="pw_lama"
                                    style="width:100%;padding:10px 42px 10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                    placeholder="••••••••"
                                    onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#e2e8f0'">
                                <button type="button" onclick="togglePw('pw_lama','eye_lama')"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#94a3b8;">
                                    <svg id="eye_lama" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')<p style="font-size:0.72rem;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Password Baru <span style="color:#dc2626;">*</span></label>
                            <div style="position:relative;">
                                <input type="password" name="password" id="pw_baru"
                                    style="width:100%;padding:10px 42px 10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                    placeholder="Min. 8 karakter"
                                    onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#e2e8f0'">
                                <button type="button" onclick="togglePw('pw_baru','eye_baru')"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#94a3b8;">
                                    <svg id="eye_baru" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')<p style="font-size:0.72rem;color:#dc2626;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:6px;">Konfirmasi Password Baru <span style="color:#dc2626;">*</span></label>
                            <div style="position:relative;">
                                <input type="password" name="password_confirmation" id="pw_konfirm"
                                    style="width:100%;padding:10px 42px 10px 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;color:#0f172a;box-sizing:border-box;"
                                    placeholder="Ulangi password baru"
                                    onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#e2e8f0'">
                                <button type="button" onclick="togglePw('pw_konfirm','eye_konfirm')"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#94a3b8;">
                                    <svg id="eye_konfirm" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div style="margin-top:20px;display:flex;justify-content:flex-end;">
                        <button type="submit"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#dc2626,#991b1b);color:white;padding:10px 24px;border-radius:10px;border:none;font-size:0.85rem;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(220,38,38,0.3);"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
// Auto scroll ke form password jika ada error password
document.addEventListener('DOMContentLoaded', function () {
    @if($errors->has('password') || $errors->has('current_password'))
    const pwSection = document.getElementById('section-password');
    if (pwSection) {
        setTimeout(function() {
            pwSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 300);
    }
    @endif
});
function togglePw(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye   = document.getElementById(eyeId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
@endsection
@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Manajemen Siswa')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { background:#f8fafc; }
    .btn-edit { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; background:var(--navy-dark); color:white; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; transition:background 0.2s; }
    .btn-edit:hover { background:var(--navy-darkest); }
    .header-actions { display:flex; gap:10px; }
    .profile-card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .profile-header { display:flex; align-items:center; gap:20px; padding-bottom:20px; border-bottom:1px solid #f1f5f9; margin-bottom:20px; flex-wrap:wrap; }
    .profile-avatar { width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0; background:#f1f5f9; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; }
    .profile-avatar img { width:100%; height:100%; object-fit:cover; }
    .profile-avatar svg { width:40px; height:40px; color:#cbd5e1; }
    .profile-name { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .profile-nis { font-size:0.82rem; color:#64748b; margin-top:2px; }
    .profile-badges { display:flex; gap:8px; margin-top:8px; flex-wrap:wrap; }
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; }
    .badge-blue { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-green { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .badge-pink { background:#fdf2f8; color:#9d174d; border:1px solid #fbcfe8; }
    .section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:16px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .info-item { display:flex; flex-direction:column; gap:3px; }
    .info-item.full { grid-column:1 / -1; }
    .info-label { font-size:0.73rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; }
    .info-value { font-size:0.88rem; color:#1e293b; font-weight:500; }
    .info-value.empty { color:#cbd5e1; font-style:italic; font-weight:400; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .danger-zone { background:#fff8f8; border:1px solid #fee2e2; border-radius:16px; padding:20px 24px; margin-bottom:20px; }
    .danger-zone-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:#dc2626; margin-bottom:12px; }
    .btn-danger { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:#dc2626; border:1.5px solid #fca5a5; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-danger:hover { background:#fef2f2; }
    .btn-warning { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:#d97706; border:1.5px solid #fcd34d; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s; text-decoration:none; }
    .btn-warning:hover { background:#fffbeb; }
    .danger-actions { display:flex; gap:10px; flex-wrap:wrap; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Detail Profil Siswa</div>
        <div class="page-header__sub">Data lengkap — {{ $siswa->name }}</div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.siswa.index') }}" class="btn-back">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <a href="{{ route('admin.siswa.kartu', $siswa) }}" class="btn-back" style="background:#f0fdf4; color:#15803d; border-color:#86efac;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
            Kartu Identitas
        </a>
        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn-edit">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
            Edit Data
        </a>
    </div>
</div>

@if(session('success'))
<div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:0.83rem; color:#15803d; display:flex; align-items:center; gap:8px;">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- Profile Header Card --}}
<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            @if($siswa->foto)
                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->name }}">
            @else
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            @endif
        </div>
        <div>
            <div class="profile-name">{{ $siswa->name }}</div>
            <div class="profile-nis">NIS: {{ $siswa->nis }}</div>
            <div class="profile-badges">
                <span class="badge badge-blue">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z"/></svg>
                    {{ $siswa->kelas->nama ?? '-' }}
                </span>
                <span class="badge {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'badge-blue' : 'badge-pink' }}">
                    {{ $siswa->jenis_kelamin }}
                </span>
                <span class="badge badge-green">Aktif</span>
            </div>
        </div>
    </div>

    {{-- Data Pribadi --}}
    <div class="section-title">Data Pribadi</div>
    <div class="info-grid" style="margin-bottom:24px;">
        <div class="info-item">
            <div class="info-label">Tempat Lahir</div>
            <div class="info-value {{ !$siswa->tempat_lahir ? 'empty' : '' }}">
                {{ $siswa->tempat_lahir ?? 'Belum diisi' }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Tanggal Lahir</div>
            <div class="info-value {{ !$siswa->tanggal_lahir ? 'empty' : '' }}">
                {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diisi' }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">No. HP Siswa</div>
            <div class="info-value {{ !$siswa->no_hp ? 'empty' : '' }}">
                {{ $siswa->no_hp ?? 'Belum diisi' }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Email</div>
            <div class="info-value {{ !$siswa->email ? 'empty' : '' }}">
                {{ $siswa->email ?? 'Belum diisi' }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Agama</div>
            <div class="info-value {{ !$siswa->agama ? 'empty' : '' }}">
                {{ $siswa->agama ?? 'Belum diisi' }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Alamat</div>
            <div class="info-value {{ !$siswa->alamat ? 'empty' : '' }}">
                {{ $siswa->alamat ?? 'Belum diisi' }}
            </div>
        </div>
    </div>

    {{-- Data Orang Tua --}}
    <div class="section-title">Data Orang Tua / Wali</div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Nama Orang Tua / Wali</div>
            <div class="info-value {{ !$siswa->nama_ortu ? 'empty' : '' }}">
                {{ $siswa->nama_ortu ?? 'Belum diisi' }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">No. HP Orang Tua</div>
            <div class="info-value {{ !$siswa->no_hp_ortu ? 'empty' : '' }}">
                {{ $siswa->no_hp_ortu ?? 'Belum diisi' }}
            </div>
        </div>
    </div>
</div>

{{-- Danger Zone --}}
<div class="danger-zone">
    <div class="danger-zone-title">⚠ Zona Berbahaya</div>
    <div class="danger-actions">
        <form method="POST" action="{{ route('admin.siswa.reset-password', $siswa) }}" onsubmit="return confirm('Reset password {{ $siswa->name }} ke siswa123?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn-warning">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                Reset Password ke siswa123
            </button>
        </form>
        <form method="POST" action="{{ route('admin.siswa.destroy', $siswa) }}" onsubmit="return confirm('HAPUS PERMANEN data siswa {{ $siswa->name }}? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                Hapus Siswa
            </button>
        </form>
    </div>
</div>

@endsection

@extends('layouts.admin')
@section('title', 'Tambah Siswa')
@section('page-title', 'Manajemen Siswa')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { background:#f8fafc; border-color:var(--navy-dark); }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .form-section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:20px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1 / -1; }
    label { font-size:0.8rem; font-weight:600; color:#374151; }
    label span.req { color:#dc2626; margin-left:2px; }
    input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="date"], select, textarea {
        width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px;
        font-size:0.85rem; color:#1e293b; background:white; transition:border 0.2s; box-sizing:border-box;
    }
    input:focus, select:focus, textarea:focus { border-color:var(--navy-mid); outline:none; box-shadow:0 0 0 3px rgba(30,64,175,0.07); }
    textarea { resize:vertical; min-height:80px; }
    .error-msg { font-size:0.75rem; color:#dc2626; margin-top:2px; }
    .foto-preview-wrap { display:flex; align-items:center; gap:16px; margin-top:4px; }
    .foto-preview { width:72px; height:72px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0; background:#f1f5f9; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .foto-preview svg { width:36px; height:36px; color:#cbd5e1; }
    .btn-submit { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:var(--navy-dark); color:white; border:none; border-radius:10px; font-size:0.88rem; font-weight:600; cursor:pointer; transition:background 0.2s; }
    .btn-submit:hover { background:var(--navy-darkest); }
    .btn-cancel { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.88rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { background:#f8fafc; }
    .form-actions { display:flex; gap:12px; justify-content:flex-end; padding-top:8px; }
    .hint { font-size:0.73rem; color:#94a3b8; margin-top:1px; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Tambah Siswa Baru</div>
        <div class="page-header__sub">Isi data siswa dengan lengkap dan benar</div>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

@if($errors->any())
<div style="background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:14px 18px; margin-bottom:20px; font-size:0.83rem; color:#dc2626;">
    <strong>Terdapat kesalahan input:</strong>
    <ul style="margin:6px 0 0 18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.siswa.store') }}" enctype="multipart/form-data">
@csrf

{{-- SECTION 1: Data Akun Login --}}
<div class="card">
    <div class="form-section-title">Data Akun Login</div>
    <div class="form-grid">
        <div class="form-group">
            <label>NIS <span class="req">*</span></label>
            <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 2024001" required>
            <span class="hint">NIS digunakan sebagai username login siswa</span>
            @error('nis')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Nama Lengkap <span class="req">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap siswa" required>
            @error('name')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <div style="position:relative;">
                <input type="password" name="password" id="passwordCreate"
                    autocomplete="new-password"
                    placeholder="Kosongkan = otomatis pakai siswa123"
                    style="padding-right:40px;">
                <button type="button" onclick="togglePassword()"
                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;">
                    <svg id="eyeIconCreate" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>
            </div>
            <span class="hint">Jika dikosongkan, password default = siswa123</span>
            @error('password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Email <span style="font-size:0.72rem;color:#94a3b8;">(opsional)</span></label>
            <input type="email" name="email" autocomplete="off" value="{{ old('email') }}" placeholder="email@contoh.com">
            @error('email')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- SECTION 2: Data Pribadi --}}
<div class="card">
    <div class="form-section-title">Data Pribadi Siswa</div>
    <div class="form-grid">
        <div class="form-group">
            <label>Kelas <span class="req">*</span></label>
            <select name="kelas_id" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Jenis Kelamin <span class="req">*</span></label>
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Surabaya">
            @error('tempat_lahir')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>No. HP Siswa</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
            @error('no_hp')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Agama</label>
            <select name="agama">
                <option value="">-- Pilih Agama --</option>
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                    <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                @endforeach
            </select>
            @error('agama')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group full">
            <label>Alamat</label>
            <textarea name="alamat" placeholder="Alamat lengkap siswa">{{ old('alamat') }}</textarea>
            @error('alamat')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group full">
            <label>Foto Profil <span style="font-size:0.72rem;color:#94a3b8;">(opsional, maks. 2MB)</span></label>
            <div class="foto-preview-wrap">
                <div class="foto-preview" id="fotoPreview">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png" onchange="previewFoto(this)" style="font-size:0.83rem;">
            </div>
            @error('foto')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- SECTION 3: Data Orang Tua --}}
<div class="card">
    <div class="form-section-title">Data Orang Tua / Wali</div>
    <div class="form-grid">
        <div class="form-group">
            <label>Nama Orang Tua / Wali <span class="req">*</span></label>
            <input type="text" name="nama_ortu" value="{{ old('nama_ortu') }}" placeholder="Nama lengkap orang tua" required>
            @error('nama_ortu')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>No. HP Orang Tua <span class="req">*</span></label>
            <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu') }}" placeholder="08xxxxxxxxxx" required>
            @error('no_hp_ortu')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="form-actions">
    <a href="{{ route('admin.siswa.index') }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Simpan Siswa
    </button>
</div>
</form>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('fotoPreview');
            preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<script>
function togglePassword() {
    const input = document.getElementById('passwordCreate');
    const icon = document.getElementById('eyeIconCreate');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    }
}
</script>
@endsection

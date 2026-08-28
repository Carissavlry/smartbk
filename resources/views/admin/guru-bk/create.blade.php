@extends('layouts.admin')

@section('title', 'Tambah Guru BK')
@section('page-title', 'Guru BK')

@section('content')
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .page-header__title { font-size: 1.1rem; font-weight: 700; color: var(--navy-darkest); }
    .page-header__sub { font-size: 0.78rem; color: #64748b; margin-top: 2px; }
    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; background: white; color: var(--navy-dark);
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .btn-back:hover { background: #f8fafc; border-color: var(--navy-dark); }
    .btn-back svg { width: 15px; height: 15px; }
    .card {
        background: white; border-radius: 16px;
        border: 1px solid #e8edf5; padding: 28px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .form-section-title {
        font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.07em; color: var(--navy-dark);
        padding-bottom: 10px; border-bottom: 2px solid #e8edf5; margin-bottom: 20px;
    }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    label { font-size: 0.8rem; font-weight: 600; color: #374151; }
    label span.req { color: #dc2626; margin-left: 2px; }
    input[type="text"], input[type="email"], input[type="password"],
    input[type="number"], select {
        padding: 10px 14px; border: 1.5px solid #e2e8f0;
        border-radius: 10px; font-size: 0.85rem; color: var(--navy-darkest);
        background: #fafbff; transition: border-color 0.2s;
        outline: none; width: 100%; box-sizing: border-box;
    }
    input:focus, select:focus { border-color: var(--navy-dark); background: white; }
    .input-error { font-size: 0.75rem; color: #dc2626; margin-top: 2px; }
    .form-hint { font-size: 0.74rem; color: #94a3b8; margin-top: 2px; }
    .form-actions {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 12px; margin-top: 28px; padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-cancel {
        padding: 10px 22px; background: white; color: #64748b;
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.84rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .btn-cancel:hover { background: #f8fafc; }
    .btn-submit {
        padding: 10px 28px;
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-darkest));
        color: white; border: none; border-radius: 10px;
        font-size: 0.84rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(5,38,89,0.2);
    }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(5,38,89,0.28); }
    .section-gap { margin-top: 28px; }
</style>

<!-- Header -->
<div class="page-header">
    <div>
        <div class="page-header__title">Tambah Guru BK</div>
        <div class="page-header__sub">Isi data lengkap Guru Bimbingan Konseling</div>
    </div>
    <a href="{{ route('admin.guru-bk.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.guru-bk.store') }}">
        @csrf

        {{-- SEKSI 1: IDENTITAS --}}
        <div class="form-section-title">Identitas Guru BK</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Contoh: Budi Santoso, S.Pd." required>
                @error('name')<div class="input-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>NIP <span class="req">*</span></label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                       placeholder="Nomor Induk Pegawai" required>
                @error('nip')<div class="input-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Jenis Kelamin <span class="req">*</span></label>
                <select name="jenis_kelamin" required>
                    <option value="">— Pilih —</option>
                    <option value="Laki-laki"   {{ old('jenis_kelamin') === 'Laki-laki'   ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan"   {{ old('jenis_kelamin') === 'Perempuan'   ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<div class="input-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>No. HP / WhatsApp</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                       placeholder="08xxxxxxxxxx">
                @error('no_hp')<div class="input-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Pendidikan Terakhir</label>
                <select name="pendidikan_terakhir">
                    <option value="">— Pilih —</option>
                    <option value="S1" {{ old('pendidikan_terakhir') === 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('pendidikan_terakhir') === 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('pendidikan_terakhir') === 'S3' ? 'selected' : '' }}>S3</option>
                </select>
                @error('pendidikan_terakhir')<div class="input-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Tahun Mulai Bertugas</label>
                <input type="number" name="tahun_mulai_bertugas"
                       value="{{ old('tahun_mulai_bertugas') }}"
                       placeholder="Contoh: 2018" min="1990" max="{{ date('Y') }}">
                @error('tahun_mulai_bertugas')<div class="input-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- SEKSI 2: AKUN LOGIN --}}
        <div class="form-section-title section-gap">Akun Login</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="email@sekolah.sch.id">
                @error('email')<div class="input-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- SEKSI 3: KELAS BINAAN --}}
        <div class="form-section-title section-gap">Kelas Binaan</div>
        <div class="form-group full">
            <label>Pilih Kelas yang Dibina</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; margin-top: 4px;">
                @forelse ($kelasList as $k)
                <label style="display: flex; align-items: center; gap: 8px; padding: 10px 14px;
                            border: 1.5px solid {{ in_array($k->id, old('kelas_ids', [])) ? '#16a34a' : '#e2e8f0' }};
                            border-radius: 10px; cursor: pointer; font-weight: 500; font-size: 0.82rem;
                            background: {{ in_array($k->id, old('kelas_ids', [])) ? '#f0fdf4' : '#fafbff' }};
                            color: {{ in_array($k->id, old('kelas_ids', [])) ? '#166534' : 'var(--navy-darkest)' }};
                            transition: all 0.2s;"
                    onclick="var cb=this.querySelector('input'); setTimeout(()=>{ this.style.borderColor=cb.checked?'#16a34a':'#e2e8f0'; this.style.background=cb.checked?'#f0fdf4':'#fafbff'; this.style.color=cb.checked?'#166534':'var(--navy-darkest)'; this.querySelector('.check-icon').style.display=cb.checked?'block':'none'; },0);">
                    <span style="width:18px;height:18px;border-radius:4px;border:2px solid currentColor;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;font-weight:700;">
                        <span class="check-icon" style="display:{{ in_array($k->id, old('kelas_ids', [])) ? 'block' : 'none' }}">✓</span>
                    </span>
                    <input type="checkbox" name="kelas_ids[]" value="{{ $k->id }}"
                        {{ in_array($k->id, old('kelas_ids', [])) ? 'checked' : '' }}
                        style="display:none;">
                    {{ $k->nama }}
                </label>
                @empty
                <p style="font-size:0.8rem; color:#94a3b8;">Belum ada kelas tersedia.</p>
                @endforelse
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.guru-bk.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Simpan Guru BK</button>
        </div>
    </form>
</div>
@endsection
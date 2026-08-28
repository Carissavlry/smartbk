@extends('layouts.guru')

@section('title', 'Tambah Kasus Konseling')
@section('page-title', 'Konseling Individual')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-back:hover { background:#f8fafc; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .form-section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:20px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }
    label { font-size:0.8rem; font-weight:600; color:#374151; }
    label span.req { color:#dc2626; margin-left:2px; }
    input, select, textarea { width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; color:#1e293b; background:white; transition:border 0.2s; box-sizing:border-box; font-family:inherit; }
    input:focus, select:focus, textarea:focus { border-color:var(--navy-mid); outline:none; box-shadow:0 0 0 3px rgba(30,64,175,0.07); }
    textarea { resize:vertical; min-height:90px; }
    .hint { font-size:0.73rem; color:#94a3b8; margin-top:2px; }
    .form-actions { display:flex; gap:12px; justify-content:flex-end; padding-top:8px; }
    .btn-submit { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:var(--navy-dark); color:white; border:none; border-radius:10px; font-size:0.88rem; font-weight:600; cursor:pointer; }
    .btn-submit:hover { background:var(--navy-darkest); }
    .btn-cancel { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.88rem; font-weight:600; text-decoration:none; }
    .status-badge { display:inline-flex; align-items:center; gap:6px; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; border-radius:8px; padding:6px 12px; font-size:0.82rem; font-weight:700; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Tambah Kasus Konseling</div>
        <div class="page-header__sub">Catat kasus konseling baru beserta sesi pertama</div>
    </div>
    <a href="{{ route('guru-bk.konseling.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:0.83rem;color:#dc2626;">
    <strong>Terdapat kesalahan:</strong>
    <ul style="margin:6px 0 0 18px;">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('guru-bk.konseling.store') }}">
@csrf

{{-- DATA KASUS --}}
<div class="card">
    <div class="form-section-title"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> DATA KASUS</div>
    <div class="form-grid">

        <div class="form-group">
            <label>Siswa <span class="req">*</span></label>
            <select name="siswa_id" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswas as $s)
                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->name }} — {{ $s->kelas->first()->nama ?? '-' }}
                    </option>
                @endforeach
            </select>
            @error('siswa_id')<div class="hint" style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Kategori Masalah <span class="req">*</span></label>
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach(['Pribadi','Sosial','Belajar','Karir','Keluarga'] as $kat)
                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            @error('kategori')<div class="hint" style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div class="form-group full">
            <label>Deskripsi Masalah <span class="req">*</span></label>
            <textarea name="deskripsi_masalah" placeholder="Tuliskan masalah yang disampaikan siswa..." required>{{ old('deskripsi_masalah') }}</textarea>
            @error('deskripsi_masalah')<div class="hint" style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div class="form-group full">
            <label>Status</label>
            <div class="status-badge"><svg fill="currentColor" viewBox="0 0 24 24" style="width:12px;height:12px;color:#3b82f6;flex-shrink:0;"><circle cx="12" cy="12" r="8"/></svg> Baru <span style="color:#94a3b8;font-weight:400;margin-left:4px;">— otomatis</span></div>
        </div>

    </div>
</div>

{{-- DATA SESI 1 --}}
<div class="card">
    <div class="form-section-title" style="display:flex;align-items:center;gap:8px;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        SESI PERTAMA
    </div>
    <div class="form-grid">

        <div class="form-group">
            <label>Tanggal Konseling <span class="req">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            @error('tanggal')<div class="hint" style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Durasi <span class="req">*</span></label>
            <input type="number" name="durasi" value="{{ old('durasi', 30) }}" min="1" max="300" required>
            <div class="hint">Durasi dalam menit</div>
            @error('durasi')<div class="hint" style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div class="form-group full">
            <label>Tindakan Konselor <span class="req">*</span></label>
            <textarea name="tindakan_konselor" placeholder="Tuliskan tindakan yang dilakukan konselor..." required>{{ old('tindakan_konselor') }}</textarea>
            @error('tindakan_konselor')<div class="hint" style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div class="form-group full">
            <label>Rekomendasi <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
            <textarea name="rekomendasi" placeholder="Tuliskan rekomendasi untuk siswa...">{{ old('rekomendasi') }}</textarea>
        </div>

        <div class="form-group full">
            <label>Tindak Lanjut <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
            <textarea name="tindak_lanjut" placeholder="Rencana tindak lanjut...">{{ old('tindak_lanjut') }}</textarea>
        </div>

    </div>
</div>

<div class="form-actions">
    <a href="{{ route('guru-bk.konseling.index') }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Simpan Kasus & Sesi 1
    </button>
</div>

</form>
@endsection
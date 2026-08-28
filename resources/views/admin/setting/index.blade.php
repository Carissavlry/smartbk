@extends('layouts.admin')
@section('title', 'Konfigurasi Sistem')
@section('page-title', 'Konfigurasi')
@section('content')
<style>
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;}
    .page-header__title{font-size:1.1rem;font-weight:700;color:var(--navy-darkest);}
    .page-header__sub{font-size:0.78rem;color:#64748b;margin-top:2px;}
    .card{background:white;border-radius:16px;border:1px solid #e8edf5;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,0.05);margin-bottom:20px;}
    .section-title{font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--navy-dark);padding-bottom:10px;border-bottom:2px solid #e8edf5;margin-bottom:20px;}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
    .form-group{display:flex;flex-direction:column;gap:6px;}
    .form-group.full{grid-column:1 / -1;}
    label{font-size:0.8rem;font-weight:600;color:#374151;}
    label span.req{color:#dc2626;margin-left:2px;}
    input[type="text"],input[type="email"],input[type="number"],textarea{width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:0.85rem;color:#1e293b;background:white;transition:border 0.2s;box-sizing:border-box;}
    input:focus,textarea:focus{border-color:var(--navy-mid);outline:none;}
    .invalid-feedback{font-size:0.76rem;color:#dc2626;margin-top:2px;}
    .btn-submit{display:inline-flex;align-items:center;gap:6px;padding:10px 28px;background:var(--navy-dark);color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:600;cursor:pointer;transition:background 0.2s;}
    .btn-submit:hover{background:var(--navy-darkest);}
    .threshold-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}
    .threshold-card{border-radius:12px;padding:16px;border:2px solid;}
    .threshold-kuning{background:#fefce8;border-color:#fde68a;}
    .threshold-merah{background:#fff7ed;border-color:#fed7aa;}
    .threshold-hitam{background:#fef2f2;border-color:#fecaca;}
    .threshold-label{font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;}
    .threshold-kuning .threshold-label{color:#854d0e;}
    .threshold-merah .threshold-label{color:#9a3412;}
    .threshold-hitam .threshold-label{color:#991b1b;}
    .logo-preview{width:80px;height:80px;border-radius:12px;object-fit:contain;border:2px solid #e2e8f0;background:#f8fafc;padding:4px;}
    .logo-placeholder{width:80px;height:80px;border-radius:12px;border:2px dashed #e2e8f0;background:#f8fafc;display:flex;align-items:center;justify-content:center;}
    .hint{font-size:0.74rem;color:#94a3b8;margin-top:3px;}
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Konfigurasi Sistem</div>
        <div class="page-header__sub">Pengaturan identitas sekolah dan sistem SmartBK</div>
    </div>
</div>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:0.83rem;color:#15803d;display:flex;align-items:center;gap:8px;">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:0.83rem;color:#dc2626;">
    <strong>Terdapat kesalahan:</strong>
    <ul style="margin:6px 0 0 18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- IDENTITAS SEKOLAH --}}
    <div class="card">
        <div class="section-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Identitas Sekolah
        </div>
        <div class="form-grid">
            <div class="form-group full">
                <label>Nama Sekolah <span class="req">*</span></label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $settings['nama_sekolah']) }}" placeholder="Contoh: SMK Antartika 2 Sidoarjo">
                @error('nama_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>Alamat Sekolah</label>
                <textarea name="alamat_sekolah" rows="2" placeholder="Alamat lengkap sekolah...">{{ old('alamat_sekolah', $settings['alamat_sekolah']) }}</textarea>
                @error('alamat_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>No. Telepon Sekolah</label>
                <input type="text" name="telp_sekolah" value="{{ old('telp_sekolah', $settings['telp_sekolah']) }}" placeholder="031xxxxxxx">
                @error('telp_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Email Sekolah</label>
                <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $settings['email_sekolah']) }}" placeholder="info@sekolah.sch.id">
                @error('email_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>Logo Sekolah</label>
                <div style="display:flex;align-items:center;gap:16px;margin-top:4px;">
                    @if($settings['logo_sekolah'])
                        <img src="{{ asset('storage/' . $settings['logo_sekolah']) }}" class="logo-preview" alt="Logo">
                    @else
                        <div class="logo-placeholder">
                            <svg fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="width:32px;height:32px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        </div>
                    @endif
                    <div>
                        <input type="file" name="logo_sekolah" accept="image/jpg,image/jpeg,image/png" style="font-size:0.83rem;">
                        <div class="hint">Format: JPG, PNG. Maks. 2MB.</div>
                    </div>
                </div>
                @error('logo_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- THRESHOLD POIN PELANGGARAN --}}
    <div class="card">
        <div class="section-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Threshold Poin Pelanggaran
        </div>
        <p style="font-size:0.82rem;color:#64748b;margin-bottom:16px;">Atur batas poin pelanggaran untuk setiap level peringatan. Alert otomatis akan muncul saat siswa melewati batas ini.</p>
        <div class="threshold-grid">
            <div class="threshold-card threshold-kuning">
                <div class="threshold-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b" stroke="none"><circle cx="12" cy="12" r="10"/></svg>
                    Kuning — Peringatan
                </div>
                <input type="number" name="threshold_kuning" value="{{ old('threshold_kuning', $settings['threshold_kuning']) }}" min="1" max="100" style="background:white;">
                <div class="hint" style="color:#854d0e;">Poin minimal untuk peringatan pertama</div>
                @error('threshold_kuning')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="threshold-card threshold-merah">
                <div class="threshold-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#ef4444" stroke="none"><circle cx="12" cy="12" r="10"/></svg>
                    Merah — Tindakan
                </div>
                <input type="number" name="threshold_merah" value="{{ old('threshold_merah', $settings['threshold_merah']) }}" min="1" max="100" style="background:white;">
                <div class="hint" style="color:#9a3412;">Poin minimal untuk tindakan lanjut</div>
                @error('threshold_merah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="threshold-card threshold-hitam">
                <div class="threshold-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#1e293b" stroke="none"><circle cx="12" cy="12" r="10"/></svg>
                    Hitam — Kritis
                </div>
                <input type="number" name="threshold_hitam" value="{{ old('threshold_hitam', $settings['threshold_hitam']) }}" min="1" max="100" style="background:white;">
                <div class="hint" style="color:#991b1b;">Poin minimal untuk status kritis</div>
                @error('threshold_hitam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- KOP SURAT --}}
    <div class="card">
        <div class="section-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Kop Surat
        </div>
        <div class="form-group">
            <label>Teks Kop Surat</label>
            <textarea name="kop_surat" rows="4" placeholder="Contoh: PEMERINTAH KABUPATEN SIDOARJO&#10;DINAS PENDIDIKAN&#10;SMK ANTARTIKA 2 SIDOARJO&#10;Jl. Raya ... Telp. 031-...">{{ old('kop_surat', $settings['kop_surat']) }}</textarea>
            <div class="hint">Teks ini akan muncul di bagian atas laporan dan surat yang dicetak.</div>
            @error('kop_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;">
        <button type="submit" class="btn-submit">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Simpan Konfigurasi
        </button>
    </div>
</form>
@endsection
@extends('layouts.admin')
@section('title', 'Tambah Jenis Pelanggaran')
@section('page-title', 'Data Master')
@section('content')
<style>
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;}
    .page-header__title{font-size:1.1rem;font-weight:700;color:var(--navy-darkest);}
    .page-header__sub{font-size:0.78rem;color:#64748b;margin-top:2px;}
    .btn-back{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:white;color:var(--navy-dark);border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;}
    .card{background:white;border-radius:16px;border:1px solid #e8edf5;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,0.05);margin-bottom:20px;}
    .form-section-title{font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--navy-dark);padding-bottom:10px;border-bottom:2px solid #e8edf5;margin-bottom:20px;}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
    .form-group{display:flex;flex-direction:column;gap:6px;}
    .form-group.full{grid-column:1 / -1;}
    label{font-size:0.8rem;font-weight:600;color:#374151;}
    label span.req{color:#dc2626;margin-left:2px;}
    input[type="text"],input[type="number"],select,textarea{width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:0.85rem;color:#1e293b;background:white;transition:border 0.2s;box-sizing:border-box;}
    input:focus,select:focus,textarea:focus{border-color:var(--navy-mid);outline:none;}
    .invalid-feedback{font-size:0.76rem;color:#dc2626;margin-top:2px;}
    .btn-submit{display:inline-flex;align-items:center;gap:6px;padding:10px 24px;background:var(--navy-dark);color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:600;cursor:pointer;}
    .toggle-wrapper{display:flex;align-items:center;gap:10px;}
    .toggle{position:relative;width:44px;height:24px;}
    .toggle input[type="checkbox"]{opacity:0;width:0;height:0;}
    .slider{position:absolute;cursor:pointer;inset:0;background:#e2e8f0;border-radius:24px;transition:0.3s;}
    .slider:before{position:absolute;content:"";height:18px;width:18px;left:3px;bottom:3px;background:white;border-radius:50%;transition:0.3s;}
    input:checked + .slider{background:var(--navy-dark);}
    input:checked + .slider:before{transform:translateX(20px);}
</style>
<div class="page-header">
    <div>
        <div class="page-header__title">Tambah Jenis Pelanggaran</div>
        <div class="page-header__sub">Isi data jenis pelanggaran baru</div>
    </div>
    <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn-back">Kembali</a>
</div>
<form method="POST" action="{{ route('admin.jenis-pelanggaran.store') }}">
    @csrf
    <div class="card">
        <div class="form-section-title">Informasi Pelanggaran</div>
        <div class="form-grid">
            <div class="form-group full">
                <label>Nama Pelanggaran <span class="req">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Terlambat masuk sekolah" class="{{ $errors->has('nama') ? 'is-invalid' : '' }}">
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group full">
                <label>Kategori <span class="req">*</span></label>
                <select name="kategori" class="{{ $errors->has('kategori') ? 'is-invalid' : '' }}">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="ringan" {{ old('kategori') == 'ringan' ? 'selected' : '' }}>Ringan (poin 1-20)</option>
                    <option value="sedang" {{ old('kategori') == 'sedang' ? 'selected' : '' }}>Sedang (poin 21-50)</option>
                    <option value="berat" {{ old('kategori') == 'berat' ? 'selected' : '' }}>Berat (poin 51-100)</option>
                </select>
                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Poin Sanksi <span class="req">*</span></label>
                <input type="number" name="poin" value="{{ old('poin', 1) }}" min="1" max="100" class="{{ $errors->has('poin') ? 'is-invalid' : '' }}">
                @error('poin') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="toggle-wrapper" style="margin-top:8px;">
                    <label class="toggle">
                        <input type="checkbox" name="is_aktif" checked>
                        <span class="slider"></span>
                    </label>
                    <span style="font-size:0.83rem;color:#374151;">Aktif</span>
                </div>
            </div>
            <div class="form-group full">
                <label>Deskripsi <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                <textarea name="deskripsi" rows="3" placeholder="Penjelasan singkat...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;">
        <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn-back">Batal</a>
        <button type="submit" class="btn-submit">Simpan</button>
    </div>
</form>
@endsection
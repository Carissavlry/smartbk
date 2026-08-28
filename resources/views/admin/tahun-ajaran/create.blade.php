@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran')
@section('page-title', 'Tahun Ajaran')

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        color: var(--navy-dark);
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back:hover { background: #f1f5f9; }
    .btn-back svg { width: 18px; height: 18px; }

    .page-header__title { font-size: 1.1rem; font-weight: 700; color: var(--navy-darkest); }
    .page-header__sub { font-size: 0.78rem; color: #64748b; margin-top: 2px; }

    .form-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8edf5;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        max-width: 640px;
    }

    .form-card__header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-card__icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--navy-darkest), var(--navy-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .form-card__icon svg { width: 20px; height: 20px; }
    .form-card__title { font-size: 0.92rem; font-weight: 700; color: var(--navy-darkest); }
    .form-card__sub { font-size: 0.75rem; color: #64748b; }
    .form-card__body { padding: 24px; }

    .form-group { margin-bottom: 20px; }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--navy-darkest);
        margin-bottom: 7px;
    }

    .form-label span { color: #dc2626; }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.82rem;
        color: var(--navy-darkest);
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--navy-mid);
        box-shadow: 0 0 0 3px rgba(84,131,179,0.12);
    }

    .form-control.is-invalid { border-color: #dc2626; }

    .form-error {
        margin-top: 5px;
        font-size: 0.74rem;
        color: #dc2626;
        font-weight: 500;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-check:hover { border-color: var(--navy-mid); background: #f8faff; }

    .form-check input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--navy-dark);
        cursor: pointer;
    }

    .form-check__label { font-size: 0.82rem; font-weight: 600; color: var(--navy-darkest); cursor: pointer; }
    .form-check__sub { font-size: 0.72rem; color: #64748b; }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
        padding-top: 20px;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-darkest));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(5,38,89,0.2);
    }

    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(5,38,89,0.28); }
    .btn-submit svg { width: 16px; height: 16px; }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel:hover { background: #f8fafc; color: var(--navy-darkest); }
</style>

<!-- Header -->
<div class="page-header">
    <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <div class="page-header__title">Tambah Tahun Ajaran</div>
        <div class="page-header__sub">Isi data tahun ajaran baru</div>
    </div>
</div>

<!-- Form Card -->
<div class="form-card">
    <div class="form-card__header">
        <div class="form-card__icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <div class="form-card__title">Data Tahun Ajaran</div>
            <div class="form-card__sub">Masukkan informasi tahun ajaran</div>
        </div>
    </div>

    <div class="form-card__body">
        <form method="POST" action="{{ route('admin.tahun-ajaran.store') }}">
            @csrf

            <!-- Nama Tahun Ajaran -->
            <div class="form-group">
                <label class="form-label" for="nama">
                    Nama Tahun Ajaran <span>*</span>
                </label>
                <div style="display:flex; gap:8px; align-items:center;">
                    <input type="number" id="tahun_mulai" min="2000" max="2099"
                        value="{{ old('nama') ? substr(old('nama'),0,4) : '' }}"
                        placeholder="2024"
                        class="form-control"
                        style="width:120px;"
                        oninput="generateNama(this.value)">
                    <span style="color:#94a3b8; font-weight:700; font-size:1.1rem;">→</span>
                    <input type="text" name="nama" id="nama"
                        value="{{ old('nama') }}"
                        readonly
                        placeholder="otomatis terisi..."
                        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                        style="background:#f8fafc; font-weight:600; cursor:not-allowed;">
                </div>

                @push('scripts')
                <script>
                function generateNama(val) {
                    const tahun = parseInt(val);
                    const namaField = document.getElementById('nama');
                    if (tahun >= 2000 && tahun <= 2099) {
                        namaField.value = tahun + '/' + (tahun + 1);
                    } else {
                        namaField.value = '';
                    }
                }
                // Auto-fill jika sudah ada nilai old
                window.addEventListener('DOMContentLoaded', function() {
                    const namaVal = document.getElementById('nama').value;
                    if (namaVal) {
                        document.getElementById('tahun_mulai').value = namaVal.split('/')[0];
                    }
                });
                </script>
                @endpush
                @error('nama')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Semester -->
            <div class="form-group">
                <label class="form-label" for="semester">
                    Semester <span>*</span>
                </label>
                <select
                    id="semester"
                    name="semester"
                    class="form-control {{ $errors->has('semester') ? 'is-invalid' : '' }}"
                >
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil" {{ old('semester') === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester') === 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tanggal -->
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="tanggal_mulai">
                        Tanggal Mulai <span>*</span>
                    </label>
                    <input
                        type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        value="{{ old('tanggal_mulai') }}"
                        class="form-control {{ $errors->has('tanggal_mulai') ? 'is-invalid' : '' }}"
                    >
                    @error('tanggal_mulai')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="tanggal_selesai">
                        Tanggal Selesai <span>*</span>
                    </label>
                    <input
                        type="date"
                        id="tanggal_selesai"
                        name="tanggal_selesai"
                        value="{{ old('tanggal_selesai') }}"
                        class="form-control {{ $errors->has('tanggal_selesai') ? 'is-invalid' : '' }}"
                    >
                    @error('tanggal_selesai')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Aktifkan -->
            <div class="form-group">
                <label class="form-check" for="is_aktif">
                    <input
                        type="checkbox"
                        id="is_aktif"
                        name="is_aktif"
                        {{ old('is_aktif') ? 'checked' : '' }}
                    >
                    <div>
                        <div class="form-check__label">Jadikan Tahun Ajaran Aktif</div>
                        <div class="form-check__sub">Tahun ajaran lain akan otomatis dinonaktifkan</div>
                    </div>
                </label>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn-cancel">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
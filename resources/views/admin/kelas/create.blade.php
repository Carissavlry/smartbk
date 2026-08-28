@extends('layouts.admin')

@section('title', 'Tambah Kelas')
@section('page-title', 'Kelas')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
    .btn-back {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 10px; background: white;
        border: 1px solid #e2e8f0; color: var(--navy-dark); text-decoration: none; transition: all 0.2s;
    }
    .btn-back:hover { background: #f1f5f9; }
    .btn-back svg { width: 18px; height: 18px; }
    .page-header__title { font-size: 1.1rem; font-weight: 700; color: var(--navy-darkest); }
    .page-header__sub { font-size: 0.78rem; color: #64748b; margin-top: 2px; }
    .form-card {
        background: white; border-radius: 16px; border: 1px solid #e8edf5;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05); max-width: 640px;
    }
    .form-card__header {
        padding: 20px 24px; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: 12px;
    }
    .form-card__icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: linear-gradient(135deg, var(--navy-darkest), var(--navy-dark));
        display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;
    }
    .form-card__icon svg { width: 20px; height: 20px; }
    .form-card__title { font-size: 0.92rem; font-weight: 700; color: var(--navy-darkest); }
    .form-card__sub { font-size: 0.75rem; color: #64748b; }
    .form-card__body { padding: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--navy-darkest); margin-bottom: 7px; }
    .form-label span { color: #dc2626; }
    .form-control {
        width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.82rem; color: var(--navy-darkest); background: white;
        transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit;
    }
    .form-control:focus { outline: none; border-color: var(--navy-mid); box-shadow: 0 0 0 3px rgba(84,131,179,0.12); }
    .form-control.is-invalid { border-color: #dc2626; }
    .form-error { margin-top: 5px; font-size: 0.74rem; color: #dc2626; font-weight: 500; }
    .form-hint { margin-top: 5px; font-size: 0.72rem; color: #94a3b8; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
    .nama-preview {
        margin-top: 10px; padding: 10px 14px; background: #eff6ff;
        border: 1.5px solid #bfdbfe; border-radius: 10px;
        font-size: 0.82rem; color: var(--navy-dark); display: none;
    }
    .nama-preview strong { font-size: 1rem; color: var(--navy-darkest); }
    .form-actions {
        display: flex; align-items: center; gap: 10px;
        border-top: 1px solid #f1f5f9; margin-top: 24px; padding-top: 20px;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px;
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-darkest));
        color: white; border: none; border-radius: 10px; font-size: 0.82rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(5,38,89,0.2);
    }
    .btn-submit:hover { transform: translateY(-1px); }
    .btn-submit svg { width: 16px; height: 16px; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px;
        background: white; color: #64748b; border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .btn-cancel:hover { background: #f8fafc; }
</style>

<div class="page-header">
    <a href="{{ route('admin.kelas.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <div class="page-header__title">Tambah Kelas</div>
        <div class="page-header__sub">Isi data kelas baru</div>
    </div>
</div>

<div class="form-card">
    <div class="form-card__header">
        <div class="form-card__icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <div class="form-card__title">Data Kelas</div>
            <div class="form-card__sub">Masukkan informasi kelas</div>
        </div>
    </div>

    <div class="form-card__body">
        <form method="POST" action="{{ route('admin.kelas.store') }}" id="formKelas">
            @csrf

            <div class="form-group">
                <label class="form-label" for="tahun_ajaran_id">Tahun Ajaran <span>*</span></label>
                <select id="tahun_ajaran_id" name="tahun_ajaran_id"
                        class="form-control {{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                            {{ $ta->nama }} &ndash; {{ $ta->semester }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('tahun_ajaran_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nama Kelas <span>*</span></label>
                <div class="form-grid-3">
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;margin-bottom:5px;font-weight:600;">① Tingkat</div>
                        <select id="tingkat" name="tingkat"
                                class="form-control {{ $errors->has('tingkat') ? 'is-invalid' : '' }}"
                                onchange="buildNama()">
                            <option value="">-- Pilih --</option>
                            <option value="X"   {{ old('tingkat') === 'X'   ? 'selected' : '' }}>X</option>
                            <option value="XI"  {{ old('tingkat') === 'XI'  ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('tingkat') === 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                        @error('tingkat')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;margin-bottom:5px;font-weight:600;">② Jurusan</div>
                        <select id="jurusan_select" name="jurusan"
                                class="form-control {{ $errors->has('jurusan') ? 'is-invalid' : '' }}"
                                onchange="buildNama()">
                            <option value="">-- Pilih --</option>
                            <option value="RPL" {{ old('jurusan') === 'RPL' ? 'selected' : '' }}>RPL</option>
                            <option value="TKJ" {{ old('jurusan') === 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="TM"  {{ old('jurusan') === 'TM'  ? 'selected' : '' }}>TM</option>
                            <option value="AKL" {{ old('jurusan') === 'AKL' ? 'selected' : '' }}>AKL</option>
                            <option value="PB"  {{ old('jurusan') === 'PB'  ? 'selected' : '' }}>PB</option>
                            <option value="DKV" {{ old('jurusan') === 'DKV' ? 'selected' : '' }}>DKV</option>
                        </select>
                        @error('jurusan')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;margin-bottom:5px;font-weight:600;">③ Nomor</div>
                        <input type="number" id="nomor" min="1" max="99"
                               value="{{ old('_nomor') }}"
                               placeholder="1"
                               class="form-control"
                               oninput="buildNama()">
                    </div>
                </div>
                <input type="hidden" id="nama" name="nama" value="{{ old('nama') }}">
                <div class="nama-preview" id="nama_preview">
                    Nama kelas akan tersimpan sebagai: <strong id="nama_preview_text"></strong>
                </div>
                @error('nama')<div class="form-error" style="margin-top:8px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="guru_id">Guru BK Penanggung Jawab</label>
                <select id="guru_id" name="guru_id"
                        class="form-control {{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                    <option value="">-- Belum ditugaskan --</option>
                    @foreach ($guruList as $guru)
                        <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->name }}{{ $guru->nip ? ' (NIP: '.$guru->nip.')' : '' }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Guru BK yang bertanggung jawab atas kelas ini</div>
                @error('guru_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" onclick="return validateForm()">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.kelas.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function buildNama() {
    const tingkat = document.getElementById('tingkat').value;
    const jurusan = document.getElementById('jurusan_select').value;
    const nomor   = document.getElementById('nomor').value.trim();
    const preview = document.getElementById('nama_preview');
    const previewText = document.getElementById('nama_preview_text');
    const namaHidden  = document.getElementById('nama');
    let parts = [];
    if (tingkat) parts.push(tingkat);
    if (jurusan) parts.push(jurusan);
    if (nomor)   parts.push(nomor);
    const namaFinal = parts.join(' ');
    namaHidden.value = namaFinal;
    if (namaFinal) {
        previewText.textContent = namaFinal;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
function validateForm() {
    const tingkat = document.getElementById('tingkat').value;
    const jurusan = document.getElementById('jurusan_select').value;
    const nomor   = document.getElementById('nomor').value.trim();
    if (!tingkat) { alert('Pilih Tingkat terlebih dahulu!'); return false; }
    if (!jurusan) { alert('Pilih Jurusan terlebih dahulu!'); return false; }
    if (!nomor)   { alert('Isi Nomor kelas!\nContoh: 1, 2, 3'); return false; }
    return true;
}
window.addEventListener('DOMContentLoaded', function() {
    const oldTingkat = '{{ old("tingkat") }}';
    const oldNama    = '{{ old("nama") }}';
    const oldJurusan = '{{ old("jurusan") }}';
    if (oldTingkat || oldJurusan || oldNama) {
        let nomor = oldNama;
        if (oldTingkat) nomor = nomor.replace(oldTingkat, '').trim();
        if (oldJurusan) nomor = nomor.replace(oldJurusan, '').trim();
        document.getElementById('nomor').value = nomor;
        buildNama();
    }
});
</script>
@endsection
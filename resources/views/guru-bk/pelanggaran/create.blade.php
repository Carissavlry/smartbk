@extends('layouts.guru')
@section('title', 'Tambah Pelanggaran')
@section('page-title', 'Pelanggaran & Poin')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { background:#f8fafc; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .form-section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:20px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }
    label { font-size:0.8rem; font-weight:600; color:#374151; }
    label span.req { color:#dc2626; margin-left:2px; }
    input, select, textarea {
        width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px;
        font-size:0.85rem; color:#1e293b; background:white; transition:border 0.2s; box-sizing:border-box;
        font-family:inherit;
    }
    input:focus, select:focus, textarea:focus { border-color:var(--navy-mid); outline:none; box-shadow:0 0 0 3px rgba(30,64,175,0.07); }
    textarea { resize:vertical; min-height:80px; }
    .error-msg { font-size:0.75rem; color:#dc2626; margin-top:2px; }
    .hint { font-size:0.73rem; color:#94a3b8; }
    .form-actions { display:flex; gap:12px; justify-content:flex-end; padding-top:8px; }
    .btn-submit { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:var(--maroon-mid); color:white; border:none; border-radius:10px; font-size:0.88rem; font-weight:600; cursor:pointer; transition:background 0.2s; }
    .btn-submit:hover { background:var(--maroon-dark); }
    .btn-cancel { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.88rem; font-weight:600; text-decoration:none; }
    .btn-cancel:hover { background:#f8fafc; }
    .poin-preview { display:inline-flex; align-items:center; gap:6px; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:8px; padding:6px 12px; font-size:0.82rem; font-weight:700; margin-top:4px; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Tambah Pelanggaran</div>
        <div class="page-header__sub">Catat pelanggaran siswa</div>
    </div>
    <a href="{{ route('guru-bk.pelanggaran.index') }}" class="btn-back">
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

<form method="POST" action="{{ route('guru-bk.pelanggaran.store') }}">
@csrf
<div class="card">
    <div class="form-section-title">Data Pelanggaran</div>
    <div class="form-grid">
        <div class="form-group full">
            <label>Siswa <span class="req">*</span></label>
            <select name="user_id" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswas as $siswa)
                    <option value="{{ $siswa->id }}" {{ old('user_id') == $siswa->id ? 'selected' : '' }}>
                        {{ $siswa->name }} — {{ $siswa->nis }} ({{ $siswa->kelas->nama ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('user_id')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Jenis Pelanggaran <span class="req">*</span></label>
            <select name="jenis_pelanggaran_id" id="jenisSelect" required onchange="updatePoin(this)">
                <option value="">-- Pilih Jenis --</option>
                @foreach($jenisList as $j)
                    <option value="{{ $j->id }}"
                        data-poin="{{ $j->poin }}"
                        {{ old('jenis_pelanggaran_id') == $j->id ? 'selected' : '' }}>
                        {{ $j->nama }} ({{ $j->poin }} poin)
                    </option>
                @endforeach
            </select>
            <div id="poinPreview" style="display:none;" class="poin-preview">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                <span id="poinText">0 poin</span>
            </div>
            @error('jenis_pelanggaran_id')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Tanggal <span class="req">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            @error('tanggal')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Poin <span class="req">*</span></label>
            <input type="number" name="poin" id="poinInput" value="{{ old('poin') }}" min="1" required placeholder="Otomatis dari jenis pelanggaran">
            <span class="hint">Bisa diubah manual jika perlu</span>
            @error('poin')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group full">
            <label>Keterangan <span style="font-size:0.72rem;color:#94a3b8;">(opsional)</span></label>
            <textarea name="keterangan" placeholder="Tuliskan keterangan pelanggaran...">{{ old('keterangan') }}</textarea>
            @error('keterangan')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="form-actions">
    <a href="{{ route('guru-bk.pelanggaran.index') }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Simpan Pelanggaran
    </button>
</div>
</form>

@push('scripts')
<script>
function updatePoin(select) {
    const opt = select.options[select.selectedIndex];
    const poin = opt.getAttribute('data-poin');
    const preview = document.getElementById('poinPreview');
    const poinText = document.getElementById('poinText');
    const poinInput = document.getElementById('poinInput');
    if (poin) {
        preview.style.display = 'inline-flex';
        poinText.textContent = poin + ' poin';
        poinInput.value = poin;
    } else {
        preview.style.display = 'none';
        poinInput.value = '';
    }
}
</script>
@endpush
@endsection
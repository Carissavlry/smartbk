@extends('layouts.guru')
@section('title', 'Edit Pelanggaran')
@section('page-title', 'Pelanggaran & Poin')
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
        <div class="page-header__title">Edit Pelanggaran</div>
        <div class="page-header__sub">Ubah data pelanggaran siswa</div>
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

<form method="POST" action="{{ route('guru-bk.pelanggaran.update', $pelanggaran) }}">
@csrf @method('PUT')
<div class="card">
    <div class="form-section-title">Data Pelanggaran</div>
    <div class="form-grid">

        <div class="form-group full">
            <label>Siswa <span class="req">*</span></label>
            <select name="user_id" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswas as $siswa)
                    <option value="{{ $siswa->id }}" {{ old('user_id', $pelanggaran->user_id) == $siswa->id ? 'selected' : '' }}>
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
                        {{ old('jenis_pelanggaran_id', $pelanggaran->jenis_pelanggaran_id) == $j->id ? 'selected' : '' }}>
                        {{ $j->nama }} ({{ $j->poin }} poin)
                    </option>
                @endforeach
            </select>
            @error('jenis_pelanggaran_id')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Tanggal <span class="req">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', $pelanggaran->tanggal->format('Y-m-d')) }}" required>
            @error('tanggal')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Poin <span class="req">*</span></label>
            <input type="number" name="poin" id="poinInput" value="{{ old('poin', $pelanggaran->poin) }}" min="1" required>
            <span class="hint">Bisa diubah manual jika perlu</span>
            @error('poin')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group full">
            <label>Keterangan <span style="font-size:0.72rem;color:#94a3b8;">(opsional)</span></label>
            <textarea name="keterangan" placeholder="Tuliskan keterangan pelanggaran...">{{ old('keterangan', $pelanggaran->keterangan) }}</textarea>
            @error('keterangan')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

    </div>
</div>

<div class="form-actions">
    <a href="{{ route('guru-bk.pelanggaran.index') }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Simpan Perubahan
    </button>
</div>
</form>

@push('scripts')
<script>
function updatePoin(select) {
    const opt = select.options[select.selectedIndex];
    const poin = opt.getAttribute('data-poin');
    const poinInput = document.getElementById('poinInput');
    if (poin) { poinInput.value = poin; }
}
// Set poin awal saat halaman load
window.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('jenisSelect');
    if (jenisSelect.value) {
        const opt = jenisSelect.options[jenisSelect.selectedIndex];
        // Tidak override nilai existing — biarkan dari DB
    }
});
</script>
@endpush

@endsection
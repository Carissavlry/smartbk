@extends('layouts.guru')

@section('title', 'Detail Kunjungan')
@section('page-title', 'Home Visit')

@section('content')
<style>
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-back:hover { background:#f8fafc; }
    .btn-edit { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:var(--navy-dark); color:white; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-edit:hover { background:var(--navy-darkest); color:white; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
    .card-header-title { font-size:0.82rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .card-body { padding:24px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .info-item label { font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; display:block; margin-bottom:4px; }
    .info-item .value { font-size:0.88rem; font-weight:500; color:#1e293b; line-height:1.6; }
    .info-item.full { grid-column:1/-1; }
    .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:0.83rem; color:#15803d; display:flex; align-items:center; gap:8px; }
    .nomor-surat-badge { display:inline-flex; align-items:center; gap:8px; padding:6px 14px; background:#eff6ff; border:1.5px solid #bfdbfe; border-radius:9px; font-size:0.83rem; font-weight:700; color:#1d4ed8; }
    .badge { display:inline-flex; align-items:center; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-green { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .badge-red { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
    .foto-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:12px; }
    .foto-item { position:relative; border-radius:10px; overflow:hidden; border:1.5px solid #e2e8f0; }
    .foto-item img { width:100%; height:120px; object-fit:cover; display:block; }
    .foto-item .foto-del { position:absolute; top:6px; right:6px; background:rgba(220,38,38,0.85); color:white; border:none; border-radius:6px; padding:3px 7px; font-size:0.7rem; cursor:pointer; }
    .foto-item .foto-del:hover { background:#dc2626; }
</style>

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
    <a href="{{ route('guru-bk.home-visit.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <a href="{{ route('guru-bk.home-visit.edit', $homeVisit) }}" class="btn-edit">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit
    </a>
</div>

@if(session('success'))
<div class="alert-success">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- INFORMASI UMUM --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span class="card-header-title">Informasi Umum</span>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item full">
                <label>Nomor Surat</label>
                <div class="value">
                    <span class="nomor-surat-badge">{{ $homeVisit->nomor_surat ?? '-' }}</span>
                </div>
            </div>
            <div class="info-item">
                <label>Siswa</label>
                <div class="value" style="font-weight:600;">{{ $homeVisit->siswa->name }}</div>
            </div>
            <div class="info-item">
                <label>Kelas</label>
                <div class="value">{{ $homeVisit->siswa->kelas->nama ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Tanggal Kunjungan</label>
                <div class="value">{{ $homeVisit->tanggal->translatedFormat('d F Y') }}</div>
            </div>
            <div class="info-item">
                <label>Jam Kunjungan</label>
                <div class="value">
                    {{ $homeVisit->jam_mulai ? \Carbon\Carbon::parse($homeVisit->jam_mulai)->format('H:i') : '-' }}
                    —
                    {{ $homeVisit->jam_selesai ? \Carbon\Carbon::parse($homeVisit->jam_selesai)->format('H:i') : '-' }}
                </div>
            </div>
            <div class="info-item">
                <label>Yang Menemani Guru BK</label>
                <div class="value">{{ $homeVisit->yang_menemani ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Status Kehadiran Orang Tua</label>
                <div class="value">
                    @if($homeVisit->status_kehadiran_ortu === 'Ada')
                        <span class="badge badge-green">Ada</span>
                    @else
                        <span class="badge badge-red">Tidak Ada</span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <label>Dicatat Oleh</label>
                <div class="value">{{ $homeVisit->guruBk->name }}</div>
            </div>
        </div>
    </div>
</div>

{{-- DATA ORANG TUA --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="card-header-title">Data Orang Tua / Wali</span>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item full">
                <label>Alamat Rumah</label>
                <div class="value">{{ $homeVisit->alamat ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Nama Orang Tua / Wali</label>
                <div class="value">{{ $homeVisit->nama_ortu ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>No HP Orang Tua</label>
                <div class="value">{{ $homeVisit->no_hp_ortu ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- CATATAN KUNJUNGAN --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span class="card-header-title">Catatan Kunjungan</span>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item full">
                <label>Tujuan Kunjungan</label>
                <div class="value">{{ $homeVisit->tujuan }}</div>
            </div>
            <div class="info-item full">
                <label>Kondisi Lingkungan Rumah</label>
                <div class="value">{{ $homeVisit->kondisi_lingkungan ?? '-' }}</div>
            </div>
            <div class="info-item full">
                <label>Hasil Kunjungan</label>
                <div class="value">{{ $homeVisit->hasil ?? '-' }}</div>
            </div>
            <div class="info-item full">
                <label>Kesimpulan</label>
                <div class="value">{{ $homeVisit->kesimpulan ?? '-' }}</div>
            </div>
            <div class="info-item full">
                <label>Rekomendasi</label>
                <div class="value">{{ $homeVisit->rekomendasi ?? '-' }}</div>
            </div>
            <div class="info-item full">
                <label>Tindak Lanjut</label>
                <div class="value">{{ $homeVisit->tindak_lanjut ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- FOTO DOKUMENTASI --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <span class="card-header-title">Foto Dokumentasi ({{ $homeVisit->fotos->count() }})</span>
    </div>
    <div class="card-body">
        @if($homeVisit->fotos->count() > 0)
        <div class="foto-grid">
            @foreach($homeVisit->fotos as $index => $foto)
            <div class="foto-item">
                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto ke-{{ $index + 1 }}"
                    onclick="bukaFoto('{{ asset('storage/' . $foto->foto) }}')"
                    style="cursor:pointer;" title="Klik untuk perbesar">
                <span style="font-size:0.7rem; color:#64748b; font-weight:600; text-align:center; display:block; margin-top:4px;">
                    Foto ke-{{ $index + 1 }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:24px;color:#94a3b8;font-size:0.83rem;">
            Belum ada foto dokumentasi
        </div>
        @endif
    </div>
</div>
{{-- LIGHTBOX --}}
<div id="lightbox" onclick="tutupFoto()"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:9999; align-items:center; justify-content:center; cursor:zoom-out;">
    <img id="lightboxImg" src="" style="max-width:90vw; max-height:90vh; border-radius:12px; box-shadow:0 8px 32px rgba(0,0,0,0.5);">
</div>

@push('scripts')
<script>
function bukaFoto(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').style.display = 'flex';
}
function tutupFoto() {
    document.getElementById('lightbox').style.display = 'none';
}
</script>
@endpush
@endsection
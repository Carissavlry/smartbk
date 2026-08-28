@extends('layouts.guru')

@section('title', 'Detail Kasus Konseling')
@section('page-title', 'Konseling Individual')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-back:hover { background:#f8fafc; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:20px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .info-item label { font-size:0.72rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; display:block; margin-bottom:4px; }
    .info-item span { font-size:0.88rem; color:#1e293b; font-weight:500; }
    .info-item.full { grid-column:1/-1; }

    /* Badge Status */
    .badge { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:0.78rem; font-weight:700; }
    .badge-blue   { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-yellow { background:#fefce8; color:#a16207; border:1px solid #fde047; }
    .badge-green  { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }

    /* Tombol Aksi Status */
    .status-actions { display:flex; gap:10px; flex-wrap:wrap; margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9; }
    .btn-status { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; border:none; border-radius:10px; font-size:0.83rem; font-weight:600; cursor:pointer; }
    .btn-lanjut  { background:#1d4ed8; color:white; text-decoration:none; }
    .btn-lanjut:hover { background:#1e40af; }
    .btn-selesai { background:#15803d; color:white; }
    .btn-selesai:hover { background:#166534; }
    .btn-edit-kasus { background:white; color:#64748b; border:1.5px solid #e2e8f0; text-decoration:none; }
    .btn-edit-kasus:hover { background:#f8fafc; }
    .btn-hapus { background:#fef2f2; color:#dc2626; border:1.5px solid #fecaca; }
    .btn-hapus:hover { background:#fee2e2; }

    /* Riwayat Sesi */
    .sesi-list { display:flex; flex-direction:column; gap:12px; }
    .sesi-item { background:#f8fafc; border:1px solid #e8edf5; border-radius:12px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .sesi-item:hover { background:#f1f5f9; }
    .sesi-badge { background:#eff6ff; color:#1d4ed8; border:1.5px solid #bfdbfe; border-radius:8px; padding:4px 10px; font-size:0.75rem; font-weight:700; white-space:nowrap; }
    .sesi-info { flex:1; }
    .sesi-info strong { font-size:0.88rem; color:#1e293b; }
    .sesi-info small { display:block; font-size:0.75rem; color:#94a3b8; margin-top:2px; }
    .btn-lihat-sesi { display:inline-flex; align-items:center; gap:5px; padding:6px 14px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.78rem; font-weight:600; text-decoration:none; white-space:nowrap; }
    .btn-lihat-sesi:hover { background:#f8fafc; }
    .empty-sesi { text-align:center; padding:24px; color:#94a3b8; font-size:0.85rem; }
</style>

{{-- Header --}}
<div class="page-header">
    <div>
        <div style="font-size:1.1rem;font-weight:700;color:var(--navy-darkest);">Detail Kasus Konseling</div>
        <div style="font-size:0.78rem;color:#64748b;margin-top:2px;">{{ $konseling->siswa->name }} — {{ $konseling->kategori }}</div>
    </div>
    <a href="{{ route('guru-bk.konseling.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:0.83rem;color:#15803d;font-weight:600;">
    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline;vertical-align:middle;margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}
</div>
@endif

{{-- Info Kasus --}}
<div class="card">
    <div class="section-title" style="display:flex;align-items:center;gap:8px;"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> INFORMASI KASUS</div>
    <div class="info-grid">
        <div class="info-item">
            <label>Siswa</label>
            <span>{{ $konseling->siswa->name }}</span>
        </div>
        <div class="info-item">
            <label>Kelas</label>
            <span>{{ $konseling->siswa->kelas->first()->nama ?? '-' }}</span>
        </div>
        <div class="info-item">
            <label>Kategori</label>
            <span>{{ $konseling->kategori }}</span>
        </div>
        <div class="info-item">
            <label>Total Sesi</label>
            <span>{{ $konseling->sesi->count() }} sesi</span>
        </div>
        <div class="info-item">
            <label>Status</label>
            <span>
                @php
                    $badge = match($konseling->status) {
                        'baru'         => ['class'=>'badge-blue',   'label'=>'Baru'],
                        'dalam_proses' => ['class'=>'badge-yellow', 'label'=>'Dalam Proses'],
                        'selesai'      => ['class'=>'badge-green',  'label'=>'Selesai'],
                        default        => ['class'=>'badge-blue',   'label'=>$konseling->status],
                    };
                @endphp
                <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
            </span>
        </div>
        <div class="info-item">
            <label>Dibuat</label>
            <span>{{ \Carbon\Carbon::parse($konseling->sesi->first()->tanggal ?? $konseling->created_at)->translatedFormat('d F Y') }}</span>
        </div>
        <div class="info-item full">
            <label>Deskripsi Masalah</label>
            <span style="white-space:pre-line;">{{ $konseling->deskripsi_masalah }}</span>
        </div>
    </div>
    {{-- Banner Selesai --}}
    @if($konseling->status === 'selesai')
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 18px;margin-top:16px;display:flex;align-items:center;gap:10px;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;color:#15803d;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <div style="font-size:0.85rem;font-weight:700;color:#15803d;">Konseling Selesai</div>
            <div style="font-size:0.78rem;color:#166534;margin-top:1px;">Kasus ini telah ditandai selesai. Anda tidak dapat menambah sesi atau mengedit kasus ini.</div>
        </div>
    </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="status-actions">

        @if($konseling->status !== 'selesai')
        {{-- Tombol Lanjut Konseling --}}
        <a href="{{ route('guru-bk.konseling.sesi.create', $konseling) }}" class="btn-status btn-lanjut">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Lanjut Konseling
        </a>

        {{-- Tombol Selesai --}}
        <form method="POST" action="{{ route('guru-bk.konseling.updateStatus', $konseling) }}" style="display:inline;">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="selesai">
            <button type="submit" class="btn-status btn-selesai"
                onclick="return confirm('Tandai kasus ini sebagai Selesai?')">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Selesai
            </button>
        </form>
        @endif

        {{-- Tombol Edit --}}
        @if($konseling->status !== 'selesai')
        <a href="{{ route('guru-bk.konseling.edit', $konseling) }}" class="btn-status btn-edit-kasus">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2a2 2 0 01.586-1.414z"/></svg>
            Edit Kasus
        </a>
        @endif

        {{-- Tombol Hapus --}}
        <form method="POST" action="{{ route('guru-bk.konseling.destroy', $konseling) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-status btn-hapus"
                onclick="return confirm('Hapus kasus konseling ini beserta semua sesinya?')">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4h8v3"/></svg>
                Hapus
            </button>
        </form>
    </div>
</div>

{{-- Riwayat Sesi --}}
<div class="card">
    <div class="section-title" style="display:flex;align-items:center;gap:8px;"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> RIWAYAT SESI</div>

    @if($konseling->sesi->count() > 0)
    <div class="sesi-list">
        @foreach($konseling->sesi as $sesi)
        <div class="sesi-item">
            <span class="sesi-badge">Sesi {{ $sesi->ke }}</span>
            <div class="sesi-info">
                <strong>{{ $sesi->tanggal->format('d M Y') }}</strong>
                <small>Durasi: {{ $sesi->durasi }} menit · {{ Str::limit($sesi->tindakan_konselor, 60) }}</small>
            </div>
            <a href="{{ route('guru-bk.konseling.sesi.show', [$konseling, $sesi]) }}" class="btn-lihat-sesi">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Lihat
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-sesi">Belum ada sesi tercatat.</div>
    @endif
</div>
@endsection
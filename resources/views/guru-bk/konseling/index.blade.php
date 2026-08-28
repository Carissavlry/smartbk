@extends('layouts.guru')

@section('title', 'Konseling Individual')
@section('page-title', 'Konseling Individual')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-tambah { display:inline-flex; align-items:center; gap:7px; padding:9px 20px; background:var(--navy-dark); color:white; border-radius:10px; font-size:0.85rem; font-weight:600; text-decoration:none; }
    .btn-tambah:hover { background:var(--navy-darkest); }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .filter-bar { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
    .filter-group { display:flex; flex-direction:column; gap:4px; flex:1; min-width:140px; }
    .filter-group label { font-size:0.72rem; font-weight:600; color:#64748b; }
    .filter-group input, .filter-group select { padding:7px 10px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; color:#1e293b; background:white; width:100%; }
    .btn-filter { padding:8px 20px; background:var(--navy-dark); color:white; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; align-self:flex-end; white-space:nowrap; }
    .btn-reset { padding:8px 16px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; font-weight:600; text-decoration:none; align-self:flex-end; white-space:nowrap; }

    /* Table */
    table { width:100%; border-collapse:collapse; }
    thead th { padding:11px 16px; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; background:#f8fafc; border-bottom:1px solid #e8edf5; text-align:left; }
    tbody td { padding:13px 16px; font-size:0.84rem; color:#1e293b; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:#f8fafc; }

    /* Badge */
    .badge { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px; font-size:0.73rem; font-weight:700; }
    .badge-blue   { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-yellow { background:#fefce8; color:#a16207; border:1px solid #fde047; }
    .badge-green  { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }

    .btn-detail { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; background:var(--navy-dark); color:white; border-radius:7px; font-size:0.75rem; font-weight:600; text-decoration:none; }
    .btn-detail:hover { background:var(--navy-darkest); }
    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .empty-state svg { width:40px; height:40px; margin-bottom:12px; opacity:0.4; }
    .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
</style>

{{-- Header --}}
<div class="page-header">
    <div>
        <div class="page-header__title">Konseling Individual</div>
        <div class="page-header__sub">Daftar kasus konseling siswa binaan</div>
    </div>
    <a href="{{ route('guru-bk.konseling.create') }}" class="btn-tambah">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Kasus
    </a>
</div>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:0.83rem;color:#15803d;font-weight:600;">
    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:6px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}
</div>
@endif

{{-- FILTER CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
        <span class="card-header-title">Filter & Pencarian</span>
    </div>
    <div class="filter-bar" style="border-bottom:none;">
        <form method="GET" action="{{ route('guru-bk.konseling.index') }}" style="width:100%;">
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:14px; align-items:flex-end;">
                <div class="filter-group">
                    <label>Cari Siswa</label>
                    <input type="text" name="siswa" value="{{ request('siswa') }}" placeholder="Nama / NIS...">
                </div>
                <div class="filter-group">
                    <label>Kategori</label>
                    <select name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach(['Pribadi','Sosial','Belajar','Karir','Keluarga'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="dalam_proses" {{ request('status') == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn-filter">Cari</button>
                    <a href="{{ route('guru-bk.konseling.index') }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- DATA CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        <span class="card-header-title">Data Konseling Individual</span>
    </div>

    {{-- Table --}}
    @if($konselings->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Kategori</th>
                <th>Total Sesi</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($konselings as $i => $k)
            <tr>
                <td style="color:#94a3b8;">{{ $konselings->firstItem() + $i }}</td>
                <td>
                    <div style="font-weight:600;">{{ $k->siswa->name }}</div>
                    <div style="font-size:0.75rem;color:#94a3b8;">{{ $k->siswa->nis ?? '-' }}</div>
                </td>
                <td>{{ $k->kategori }}</td>
                <td>
                    <span style="font-weight:700;color:var(--navy-dark);">{{ $k->sesi->count() }}</span>
                    <span style="color:#94a3b8;font-size:0.78rem;"> sesi</span>
                </td>
                <td>
                    @php
                        $badge = match($k->status) {
                            'baru'         => ['class'=>'badge-blue',   'label'=>'🔵 Baru'],
                            'dalam_proses' => ['class'=>'badge-yellow', 'label'=>'🟡 Dalam Proses'],
                            'selesai'      => ['class'=>'badge-green',  'label'=>'🟢 Selesai'],
                            default        => ['class'=>'badge-blue',   'label'=>$k->status],
                        };
                    @endphp
                    <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                </td>
                <td style="color:#64748b;">{{ $k->created_at->translatedFormat('d F Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('guru-bk.konseling.show', $k) }}" class="btn-detail">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail
                        </a>
                        <form method="POST" action="{{ route('guru-bk.konseling.destroy', $k) }}" onsubmit="return confirm('Hapus kasus konseling ini beserta semua sesinya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:#fef2f2;color:#dc2626;border:1.5px solid #fecaca;border-radius:7px;font-size:0.75rem;font-weight:600;cursor:pointer;">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($konselings->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f1f5f9;">
        {{ $konselings->withQueryString()->links() }}
    </div>
    @endif

    @else
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:48px;height:48px;display:block;margin:0 auto 12px;opacity:0.3;"><rect x="4" y="2" width="16" height="20" rx="2" stroke-width="1.5"/><path stroke-linecap="round" d="M8 7h8M8 11h8M8 15h5"/></svg>
        <div style="font-weight:600;color:#64748b;margin-bottom:4px;">Belum ada kasus konseling</div>
        <div style="font-size:0.8rem;">Klik <strong>Tambah Kasus</strong> untuk mulai mencatat</div>
    </div>
    @endif
</div>
@endsection
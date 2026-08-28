@extends('layouts.guru')

@section('title', 'Data Siswa Binaan')
@section('page-title', 'Data Siswa Binaan')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .filter-bar { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
    .filter-group { display:flex; flex-direction:column; gap:4px; flex:1; min-width:140px; }
    .filter-group label { font-size:0.72rem; font-weight:600; color:#64748b; }
    .filter-group input, .filter-group select { padding:7px 10px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; color:#1e293b; background:white; width:100%; }
    .btn-filter { padding:8px 20px; background:var(--navy-dark); color:white; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; align-self:flex-end; }
    .btn-reset { padding:8px 16px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; font-weight:600; text-decoration:none; align-self:flex-end; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:11px 16px; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; background:#f8fafc; border-bottom:1px solid #e8edf5; text-align:left; }
    tbody td { padding:13px 16px; font-size:0.84rem; color:#1e293b; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:#f8fafc; }
    .avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--navy-dark),var(--maroon-mid,#75162E)); display:flex; align-items:center; justify-content:center; color:white; font-size:0.78rem; font-weight:700; flex-shrink:0; }
    .badge-gender { display:inline-flex; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-l { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-p { background:#fdf4ff; color:#9333ea; border:1px solid #e9d5ff; }
    .btn-detail { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; background:var(--navy-dark); color:white; border-radius:7px; font-size:0.75rem; font-weight:600; text-decoration:none; }
    .btn-detail:hover { background:var(--navy-darkest); }
    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .poin-badge { display:inline-flex; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
    .poin-aman { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .poin-sedang { background:#fffbeb; color:#d97706; border:1px solid #fcd34d; }
    .poin-tinggi { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
    .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Data Siswa Binaan</div>
        <div class="page-header__sub">Daftar siswa yang menjadi binaan Anda</div>
    </div>
</div>

{{-- FILTER CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
        <span class="card-header-title">Filter & Pencarian</span>
    </div>
    <div class="filter-bar" style="border-bottom:none;">
        <form method="GET" action="{{ route('guru-bk.siswa-binaan.index') }}" style="width:100%;">
            <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:14px; align-items:flex-end;">
                <div class="filter-group">
                    <label>Cari Siswa</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / NIS...">
                </div>
                <div class="filter-group">
                    <label>Kelas</label>
                    <select name="kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasBinaan as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn-filter">Cari</button>
                    <a href="{{ route('guru-bk.siswa-binaan.index') }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- DATA CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="card-header-title">Data Siswa Binaan</span>
    </div>

    @if($siswas->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>No. HP</th>
                <th>Total Poin & Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $i => $siswa)
            @php
                $totalPoin = $siswa->pelanggarans->sum('poin') ?? 0;
                $level = \App\Helpers\ThresholdHelper::getLevel($totalPoin);
                $styles = [
                    'aman'   => 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;',
                    'kuning' => 'background:#fefce8;color:#a16207;border:1px solid #fde047;',
                    'merah'  => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                    'hitam'  => 'background:#1e1e2e;color:#f8fafc;border:1px solid #374151;',
                ];
                $labels = ['aman'=>'Aman','kuning'=>'Peringatan','merah'=>'Tindakan','hitam'=>'Kritis'];
                $svgIcons = [
                    'aman'   => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'kuning' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>',
                    'merah'  => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.051 3.378c.866-1.5 3.032-1.5 3.898 0l7.354 12.748z"/></svg>',
                    'hitam'  => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                ];
            @endphp
            <tr>
                <td style="color:#94a3b8;">{{ $siswas->firstItem() + $i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}"
                                 style="width:34px;height:34px;border-radius:50%;object-fit:cover;flex-shrink:0;"
                                 alt="Foto">
                        @else
                            <div class="avatar">{{ strtoupper(substr($siswa->name, 0, 1)) }}</div>
                        @endif
                        <div>
                            <div style="font-weight:600;">{{ $siswa->name }}</div>
                            <div style="font-size:0.73rem;color:#94a3b8;">{{ $siswa->nis ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                <td>
                    <span class="badge-gender {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'badge-l' : 'badge-p' }}">
                        {{ $siswa->jenis_kelamin ?? '-' }}
                    </span>
                </td>
                <td style="color:#64748b;">{{ $siswa->no_hp ?? '-' }}</td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;{{ $styles[$level] }}">
                        {!! $svgIcons[$level] !!} {{ $totalPoin }} poin — {{ $labels[$level] }}
                    </span>
                </td>
                <td>
                <div style="display:flex;gap:6px;align-items:center;">
                    <a href="{{ route('guru-bk.siswa-binaan.show', $siswa) }}" class="btn-detail">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Detail
                    </a>
                    <a href="{{ route('guru-bk.chat.show', $siswa) }}"
                    style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:#0ea5e9;color:white;border-radius:7px;font-size:0.75rem;font-weight:600;text-decoration:none;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                        </svg>
                        Chat
                    </a>
                </div>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($siswas->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f1f5f9;">
        {{ $siswas->withQueryString()->links() }}
    </div>
    @endif
    @else
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:48px;height:48px;margin:0 auto 12px;opacity:0.3;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        <div style="font-weight:600;color:#64748b;margin-bottom:4px;">Belum ada siswa binaan</div>
        <div style="font-size:0.8rem;">Hubungi Admin untuk menambahkan siswa ke kelas Anda</div>
    </div>
    @endif
</div>
@endsection
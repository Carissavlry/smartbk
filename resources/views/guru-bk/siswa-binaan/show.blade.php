@extends('layouts.guru')

@section('title', 'Profil Siswa')
@section('page-title', 'Data Siswa Binaan')

@section('content')
<style>
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; margin-bottom:20px; }
    .btn-back:hover { background:#f8fafc; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
    .card-header-title { font-size:0.82rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .card-body { padding:24px; }
    .profile-top { display:flex; align-items:center; gap:20px; margin-bottom:24px; }
    .avatar-lg { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,var(--navy-dark),#75162E); display:flex; align-items:center; justify-content:center; color:white; font-size:1.4rem; font-weight:800; flex-shrink:0; }
    .profile-name { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .profile-sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .info-item label { font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; display:block; margin-bottom:4px; }
    .info-item .value { font-size:0.88rem; font-weight:500; color:#1e293b; }
    .stat-row { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:20px; }
    .stat-box { text-align:center; padding:16px; border-radius:12px; border:1px solid #e8edf5; }
    .stat-box .num { font-size:1.6rem; font-weight:800; }
    .stat-box .lbl { font-size:0.72rem; color:#64748b; margin-top:4px; }
    .badge { display:inline-flex; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-baru { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-proses { background:#fffbeb; color:#d97706; border:1px solid #fcd34d; }
    .badge-selesai { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .badge-ringan { background:#fefce8; color:#a16207; border:1px solid #fde047; }
    .badge-sedang { background:#fff7ed; color:#c2410c; border:1px solid #fdba74; }
    .badge-berat { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:10px 14px; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; background:#f8fafc; border-bottom:1px solid #e8edf5; text-align:left; }
    tbody td { padding:12px 14px; font-size:0.82rem; color:#1e293b; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    .empty-row td { text-align:center; padding:24px; color:#94a3b8; font-size:0.82rem; }
    .btn-sm { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:6px; font-size:0.73rem; font-weight:600; text-decoration:none; }
    .btn-sm-blue { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
</style>

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
    <a href="{{ route('guru-bk.siswa-binaan.index') }}" class="btn-back" style="margin-bottom:0;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <div style="display:flex;gap:8px;align-items:center;">
        <a href="{{ route('guru-bk.chat.show', $siswa) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#0ea5e9;color:white;border:none;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
            </svg>
            Chat Siswa
        </a>
        <a href="{{ route('guru-bk.siswa-binaan.kartu', $siswa) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:linear-gradient(135deg,#052659,#75162E);color:white;border:none;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
            Lihat Kartu Identitas
        </a>
    </div>
</div>

{{-- Profil Siswa --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="card-header-title">Profil Siswa</span>
    </div>
    <div class="card-body">
        <div class="profile-top">
            @if($siswa->foto)
                <img src="{{ asset('storage/' . $siswa->foto) }}"
                     style="width:64px;height:64px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid rgba(5,38,89,0.2);"
                     alt="Foto {{ $siswa->name }}">
            @else
                <div class="avatar-lg">{{ strtoupper(substr($siswa->name, 0, 1)) }}</div>
            @endif
            <div>
                <div class="profile-name">{{ $siswa->name }}</div>
                <div class="profile-sub">NIS: {{ $siswa->nis ?? '-' }} &bull; {{ $siswa->kelas->nama ?? '-' }}</div>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <label>Jenis Kelamin</label>
                <div class="value">{{ $siswa->jenis_kelamin ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Agama</label>
                <div class="value">{{ $siswa->agama ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Tempat, Tanggal Lahir</label>
                <div class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</div>
            </div>
            <div class="info-item">
                <label>Alamat</label>
                <div class="value">{{ $siswa->alamat ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>No. HP Siswa</label>
                <div class="value">{{ $siswa->no_hp ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Nama Orang Tua</label>
                <div class="value">{{ $siswa->nama_ortu ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>No. HP Orang Tua</label>
                <div class="value">{{ $siswa->no_hp_ortu ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Email</label>
                <div class="value">{{ $siswa->email ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="stat-row">
    <div class="stat-box" style="background:#eff6ff;border-color:#bfdbfe;">
        <div class="num" style="color:#1d4ed8;">{{ $konselings->count() }}</div>
        <div class="lbl">Total Konseling</div>
    </div>
    <div class="stat-box" style="background:#fef2f2;border-color:#fecaca;">
        @php
            $level = \App\Helpers\ThresholdHelper::getLevel($totalPoin);
            $statColors = [
                'aman'   => '#15803d',
                'kuning' => '#a16207',
                'merah'  => '#dc2626',
                'hitam'  => '#0f0f1a',
            ];
            $statLabels = ['aman'=>'Aman','kuning'=>'Peringatan','merah'=>'Tindakan','hitam'=>'Kritis'];
            $statBgs = [
                'aman'   => 'background:#f0fdf4;border-color:#bbf7d0;',
                'kuning' => 'background:#fefce8;border-color:#fde047;',
                'merah'  => 'background:#fef2f2;border-color:#fecaca;',
                'hitam'  => 'background:#1e1e2e;border-color:#374151;',
            ];
        @endphp
        <div class="num" style="color:{{ $statColors[$level] }};">{{ $totalPoin }}</div>
        <div class="lbl">Total Poin Pelanggaran</div>
        <div style="margin-top:6px;">
            <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:0.68rem;font-weight:700;border:1px solid;{{ $statBgs[$level] }}color:{{ $statColors[$level] }};">
                {{ $statLabels[$level] }}
            </span>
        </div>
    </div>
    <div class="stat-box" style="background:#f0fdf4;border-color:#bbf7d0;">
        <div class="num" style="color:#15803d;">{{ $konselings->where('status','selesai')->count() }}</div>
        <div class="lbl">Konseling Selesai</div>
    </div>
</div>

{{-- Riwayat Konseling --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        <span class="card-header-title">Riwayat Konseling</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Total Sesi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konselings as $i => $k)
                <tr>
                    <td style="color:#94a3b8;">{{ $i+1 }}</td>
                    <td>{{ $k->kategori }}</td>
                    <td>{{ $k->sesi->count() }} sesi</td>
                    <td>
                        @php $s = $k->status; @endphp
                        <span class="badge {{ $s=='baru' ? 'badge-baru' : ($s=='dalam_proses' ? 'badge-proses' : 'badge-selesai') }}">
                            {{ $s=='baru' ? 'Baru' : ($s=='dalam_proses' ? 'Dalam Proses' : 'Selesai') }}
                        </span>
                    </td>
                    <td style="color:#64748b;">{{ $k->created_at->translatedFormat('d F Y') }}</td>
                    <td>
                        <a href="{{ route('guru-bk.konseling.show', $k) }}" class="btn-sm btn-sm-blue">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="6">Belum ada riwayat konseling</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Riwayat Pelanggaran --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
        <span class="card-header-title">Riwayat Pelanggaran</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Kategori</th>
                    <th>Poin</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggarans as $i => $p)
                <tr>
                    <td style="color:#94a3b8;">{{ $i+1 }}</td>
                    <td>{{ $p->jenisPelanggaran->nama ?? '-' }}</td>
                    <td>
                        @php $kat = $p->jenisPelanggaran->kategori ?? '-'; @endphp
                        <span class="badge {{ $kat=='ringan' ? 'badge-ringan' : ($kat=='sedang' ? 'badge-sedang' : 'badge-berat') }}">
                            {{ ucfirst($kat) }}
                        </span>
                    </td>
                    <td style="font-weight:700;color:#dc2626;">{{ $p->poin }}</td>
                    <td style="color:#64748b;">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="5">Belum ada riwayat pelanggaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
@extends('layouts.guru')
@section('title', 'Detail Prestasi')
@section('page-title', 'Detail Prestasi')

@section('content')
<style>
.back-link { display:inline-flex; align-items:center; gap:6px; font-size:0.82rem; color:#64748b; text-decoration:none; margin-bottom:20px; }
.back-link:hover { color:var(--navy-dark); }
.card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); overflow:hidden; margin-bottom:20px; }
.card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
.card-header-left { display:flex; align-items:center; gap:8px; }
.card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
.detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:0; }
.detail-item { padding:16px 20px; border-bottom:1px solid #f8fafc; }
.detail-item.full { grid-column:1/-1; }
.detail-label { font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px; }
.detail-value { font-size:0.88rem; color:#1e293b; font-weight:500; }
.badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
.badge-akademik { background:#dbeafe; color:#1d4ed8; }
.badge-non { background:#fef3c7; color:#b45309; }
.badge-sekolah { background:#f1f5f9; color:#475569; }
.badge-kota { background:#dcfce7; color:#15803d; }
.badge-provinsi { background:#ede9fe; color:#6d28d9; }
.badge-nasional { background:#fee2e2; color:#dc2626; }
.badge-internasional { background:#fdf4ff; color:#a21caf; }
.badge-kecamatan { background:#e0f2fe; color:#0369a1; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; }
.btn-primary { background:var(--navy-dark); color:#fff; }
.btn-danger { background:#fff1f2; color:#f43f5e; }
.btn-danger:hover { background:#ffe4e6; }
.bukti-preview { max-width:320px; border-radius:10px; border:1px solid #e2e8f0; }
</style>

<a href="{{ route('guru-bk.prestasi.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Kembali ke Daftar Prestasi
</a>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:0.83rem;">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            <span class="card-header-title">Detail Prestasi</span>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('guru-bk.prestasi.edit', $prestasi) }}" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('guru-bk.prestasi.destroy', $prestasi) }}" onsubmit="return confirm('Hapus prestasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-item full">
            <div class="detail-label">Nama Siswa</div>
            <div class="detail-value" style="font-size:1rem;font-weight:700;color:var(--navy-darkest);">
                {{ $prestasi->siswa->name }}
                <span style="font-size:0.78rem;font-weight:400;color:#94a3b8;margin-left:6px;">{{ $prestasi->siswa->nis ?? '' }}</span>
            </div>
        </div>
        <div class="detail-item full">
            <div class="detail-label">Nama Prestasi</div>
            <div class="detail-value">{{ $prestasi->nama_prestasi }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Jenis</div>
            <div class="detail-value">
                <span class="badge {{ $prestasi->jenis=='Akademik' ? 'badge-akademik' : 'badge-non' }}">
                    {{ $prestasi->jenis }}
                </span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tingkat</div>
            <div class="detail-value">
                @php $tc = ['Sekolah'=>'badge-sekolah','Kecamatan'=>'badge-kecamatan','Kota'=>'badge-kota','Provinsi'=>'badge-provinsi','Nasional'=>'badge-nasional','Internasional'=>'badge-internasional'][$prestasi->tingkat] ?? 'badge-sekolah'; @endphp
                <span class="badge {{ $tc }}">{{ $prestasi->tingkat }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Peringkat</div>
            <div class="detail-value">{{ $prestasi->peringkat ?? '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tanggal</div>
            <div class="detail-value">{{ $prestasi->tanggal->format('d F Y') }}</div>
        </div>
        <div class="detail-item full">
            <div class="detail-label">Penyelenggara</div>
            <div class="detail-value">{{ $prestasi->penyelenggara ?? '-' }}</div>
        </div>
        <div class="detail-item full">
            <div class="detail-label">Keterangan</div>
            <div class="detail-value">{{ $prestasi->keterangan ?? '-' }}</div>
        </div>
        @if($prestasi->bukti)
        <div class="detail-item full">
            <div class="detail-label">Bukti / Sertifikat</div>
            <div class="detail-value" style="margin-top:8px;">
                @php $ext = pathinfo($prestasi->bukti, PATHINFO_EXTENSION); @endphp
                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                    <img src="{{ asset('storage/'.$prestasi->bukti) }}" class="bukti-preview" alt="Bukti Prestasi">
                @else
                    <a href="{{ asset('storage/'.$prestasi->bukti) }}" target="_blank" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Lihat / Download PDF
                    </a>
                @endif
            </div>
        </div>
        @endif
        <div class="detail-item">
            <div class="detail-label">Dicatat Oleh</div>
            <div class="detail-value">{{ $prestasi->pencatat->name ?? '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Dicatat Pada</div>
            <div class="detail-value">{{ $prestasi->created_at->format('d F Y, H:i') }}</div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.guru')

@section('title', 'Detail Pengajuan Konseling')
@section('page-title', 'Pengajuan Konseling')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.25rem; font-weight:700; color:var(--navy-darkest); margin:0; }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin:2px 0 0; }
    .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .18s; }
    .btn-outline { background:#fff; border:1.5px solid #e2e8f0; color:#374151; }
    .btn-outline:hover { border-color:var(--navy-dark); color:var(--navy-dark); }
    .btn-success { background:#16a34a; color:#fff; }
    .btn-success:hover { background:#15803d; color:#fff; }
    .btn-danger { background:#dc2626; color:#fff; }
    .btn-danger:hover { background:#b91c1c; color:#fff; }
    .btn-info { background:#2563eb; color:#fff; }
    .btn-info:hover { background:#1d4ed8; color:#fff; }
    .btn-w100 { width:100%; justify-content:center; }
    .card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .card-body { padding:20px; }
    .info-table { width:100%; border-collapse:collapse; font-size:0.84rem; }
    .info-table td { padding:10px 4px; border-bottom:1px solid #f1f5f9; vertical-align:top; }
    .info-table tr:last-child td { border-bottom:none; }
    .info-table .label { color:#64748b; width:42%; font-weight:500; }
    .info-table .value { color:#1e293b; font-weight:600; }
    .badge { display:inline-flex; align-items:center; gap:4px; padding:5px 14px; border-radius:20px; font-size:0.78rem; font-weight:700; }
    .badge-warning { background:#fef9c3; color:#854d0e; }
    .badge-success { background:#dcfce7; color:#166534; }
    .badge-danger { background:#fee2e2; color:#991b1b; }
    .badge-info { background:#dbeafe; color:#1e40af; }
    .badge-secondary { background:#f1f5f9; color:#475569; }
    .action-card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); overflow:hidden; }
    .action-card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .action-body { padding:20px; display:flex; flex-direction:column; gap:12px; }
    .collapse-form { background:#f8fafc; border-radius:10px; padding:16px; margin-top:4px; display:none; }
    .form-group { display:flex; flex-direction:column; gap:5px; margin-bottom:12px; }
    .form-label { font-size:0.78rem; font-weight:600; color:#374151; }
    .form-required { color:#dc2626; }
    .form-control { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.83rem; color:#1e293b; background:#fff; outline:none; width:100%; box-sizing:border-box; }
    .form-control:focus { border-color:var(--navy-dark); }
    .form-error { font-size:0.75rem; color:#dc2626; margin-top:3px; }
    .alert-success { background:#dcfce7; color:#166534; padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; font-weight:600; display:flex; align-items:center; gap:10px; }
    .alert-danger-msg { background:#fee2e2; color:#991b1b; padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; font-weight:600; display:flex; align-items:center; gap:10px; }
    .already-processed { text-align:center; padding:36px 20px; color:#94a3b8; }
    .already-processed svg { width:44px; height:44px; margin:0 auto 10px; display:block; opacity:.4; }
    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media(max-width:768px) { .grid-2 { grid-template-columns:1fr; } }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-header__title">Detail Pengajuan Konseling</h1>
        <p class="page-header__sub">Review dan ambil tindakan terhadap pengajuan siswa</p>
    </div>
    <a href="{{ route('guru-bk.konseling-pengajuan.index') }}" class="btn btn-outline">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali
    </a>
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="alert-success">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-danger-msg">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
    </svg>
    {{ session('error') }}
</div>
@endif

<div class="grid-2">

    {{-- INFO PENGAJUAN --}}
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            <span class="card-header-title">Informasi Pengajuan</span>
        </div>
        <div class="card-body">
            <table class="info-table">
                <tr>
                    <td class="label">Nama Siswa</td>
                    <td class="value">{{ $konselingPengajuan->siswa->name }}</td>
                </tr>
                <tr>
                    <td class="label">Kelas</td>
                    <td class="value">{{ $konselingPengajuan->siswa->kelas->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Topik</td>
                    <td class="value">{{ $konselingPengajuan->topik }}</td>
                </tr>
                <tr>
                    <td class="label">Deskripsi</td>
                    <td class="value" style="font-weight:400;color:#374151;">{{ $konselingPengajuan->deskripsi ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Diajukan</td>
                    <td class="value">{{ \Carbon\Carbon::parse($konselingPengajuan->tanggal_diajukan)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Jam</td>
                    <td class="value">{{ \Carbon\Carbon::parse($konselingPengajuan->jam_diajukan)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td>
                        @php
                            $badgeClass = match($konselingPengajuan->status) {
                                'menunggu'   => 'badge-warning',
                                'disetujui'  => 'badge-success',
                                'ditolak'    => 'badge-danger',
                                'reschedule' => 'badge-info',
                                'selesai'    => 'badge-secondary',
                                default      => 'badge-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $konselingPengajuan->status_label }}</span>
                    </td>
                </tr>
                @if($konselingPengajuan->status === 'ditolak')
                <tr>
                    <td class="label">Alasan Tolak</td>
                    <td style="color:#dc2626;font-size:0.83rem;">{{ $konselingPengajuan->alasan_tolak }}</td>
                </tr>
                @endif
                @if($konselingPengajuan->status === 'reschedule')
                <tr>
                    <td class="label">Jadwal Baru</td>
                    <td class="value" style="color:#2563eb;">
                        {{ \Carbon\Carbon::parse($konselingPengajuan->tanggal_reschedule)->format('d M Y') }}
                        pukul {{ \Carbon\Carbon::parse($konselingPengajuan->jam_reschedule)->format('H:i') }} WIB
                    </td>
                </tr>
                @if($konselingPengajuan->catatan_reschedule)
                <tr>
                    <td class="label">Catatan</td>
                    <td style="font-size:0.83rem;color:#374151;">{{ $konselingPengajuan->catatan_reschedule }}</td>
                </tr>
                @endif
                @endif
                @if($konselingPengajuan->status === 'disetujui' && $konselingPengajuan->konseling)
                <tr>
                    <td class="label">Sesi Konseling</td>
                    <td>
                        <a href="{{ route('guru-bk.konseling.show', $konselingPengajuan->konseling_id) }}"
                           class="btn btn-outline" style="padding:5px 12px;font-size:0.78rem;">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                            Lihat Sesi
                        </a>
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    {{-- PANEL AKSI --}}
    <div>
        @if($konselingPengajuan->status === 'menunggu')
        <div class="action-card">
            <div class="action-card-header">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                </svg>
                <span class="card-header-title">Ambil Tindakan</span>
            </div>
            <div class="action-body">

                {{-- SETUJUI --}}
                <form action="{{ route('guru-bk.konseling-pengajuan.setujui', $konselingPengajuan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-w100"
                        onclick="return confirm('Setujui pengajuan konseling dari {{ addslashes($konselingPengajuan->siswa->name) }}?')">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Setujui Pengajuan
                    </button>
                </form>

                {{-- TOLAK --}}
                <div>
                    <button onclick="toggleForm('formTolak')" class="btn btn-danger btn-w100">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tolak Pengajuan
                    </button>
                    <div class="collapse-form" id="formTolak">
                        <form action="{{ route('guru-bk.konseling-pengajuan.tolak', $konselingPengajuan->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Alasan Penolakan <span class="form-required">*</span></label>
                                <textarea name="alasan_tolak" class="form-control" rows="3"
                                    placeholder="Jelaskan alasan penolakan..." required>{{ old('alasan_tolak') }}</textarea>
                                @error('alasan_tolak')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger btn-w100">Konfirmasi Tolak</button>
                        </form>
                    </div>
                </div>

                {{-- RESCHEDULE --}}
                <div>
                    <button onclick="toggleForm('formReschedule')" class="btn btn-info btn-w100">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        Reschedule Jadwal
                    </button>
                    <div class="collapse-form" id="formReschedule">
                        <form action="{{ route('guru-bk.konseling-pengajuan.reschedule', $konselingPengajuan->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Tanggal Baru <span class="form-required">*</span></label>
                                <input type="date" name="tanggal_reschedule" class="form-control"
                                    min="{{ date('Y-m-d') }}" value="{{ old('tanggal_reschedule') }}" required>
                                @error('tanggal_reschedule')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Baru <span class="form-required">*</span></label>
                                <input type="time" name="jam_reschedule" class="form-control"
                                    value="{{ old('jam_reschedule') }}" required>
                                @error('jam_reschedule')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Catatan <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                                <textarea name="catatan_reschedule" class="form-control" rows="2"
                                    placeholder="Alasan reschedule...">{{ old('catatan_reschedule') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-info btn-w100">Konfirmasi Reschedule</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @else
        <div class="card">
            <div class="already-processed">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p style="font-size:0.88rem;font-weight:600;color:#475569;">Pengajuan sudah diproses</p>
                <p style="font-size:0.78rem;margin-top:6px;">Status: <span class="badge {{ $badgeClass ?? 'badge-secondary' }}">{{ $konselingPengajuan->status_label }}</span></p>
            </div>
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
function toggleForm(id) {
    const el = document.getElementById(id);
    const others = ['formTolak', 'formReschedule'].filter(x => x !== id);
    others.forEach(o => { document.getElementById(o).style.display = 'none'; });
    el.style.display = el.style.display === 'block' ? 'none' : 'block';
}
</script>
@endpush

@endsection
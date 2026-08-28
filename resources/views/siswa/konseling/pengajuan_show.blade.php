@extends('layouts.siswa')
@section('title', 'Detail Pengajuan Konseling')
@section('page-title', 'Detail Pengajuan')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('siswa.konseling.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:0.82rem;text-decoration:none;padding:6px 10px;border-radius:8px;margin-bottom:16px;" onmouseover="this.style.background='#f1f5f9';this.style.color='#1e3a5f'" onmouseout="this.style.background='transparent';this.style.color='#64748b'">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Riwayat Konseling
    </a>

    <div style="max-width:680px;">

        {{-- HEADER CARD --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:16px;">
            <div style="background:linear-gradient(135deg,#1e3a5f,#6b1d1d);padding:20px 24px;">
                <div style="font-size:1rem;font-weight:800;color:white;">Detail Pengajuan Konseling</div>
                <div style="font-size:0.78rem;color:rgba(255,255,255,0.7);margin-top:2px;">{{ $pengajuan->topik }}</div>
            </div>
            <div style="padding:20px 24px;display:flex;flex-direction:column;gap:14px;">

                {{-- Status --}}
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-radius:10px;
                    background:{{ $pengajuan->status === 'disetujui' ? '#dcfce7' : ($pengajuan->status === 'ditolak' ? '#fee2e2' : ($pengajuan->status === 'reschedule' ? '#ede9fe' : '#fef9c3')) }};">
                    <span style="font-size:0.82rem;font-weight:700;color:#374151;">Status Pengajuan</span>
                    <span style="font-size:0.82rem;font-weight:800;
                        color:{{ $pengajuan->status === 'disetujui' ? '#166534' : ($pengajuan->status === 'ditolak' ? '#991b1b' : ($pengajuan->status === 'reschedule' ? '#6d28d9' : '#92400e')) }};">
                        {{ ucfirst($pengajuan->status) }}
                    </span>
                </div>

                {{-- Info Baris --}}
                @php
                    $rows = [
                        ['label' => 'Topik', 'value' => $pengajuan->topik],
                        ['label' => 'Tanggal Diajukan', 'value' => \Carbon\Carbon::parse($pengajuan->tanggal_diajukan)->translatedFormat('d F Y')],
                        ['label' => 'Jam', 'value' => \Carbon\Carbon::parse($pengajuan->jam_diajukan)->format('H:i') . ' WIB'],
                        ['label' => 'Dikirim pada', 'value' => \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y, H:i')],
                    ];
                @endphp

                @foreach($rows as $row)
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:0.82rem;color:#64748b;font-weight:600;flex-shrink:0;">{{ $row['label'] }}</span>
                    <span style="font-size:0.82rem;color:#0f172a;font-weight:700;text-align:right;">{{ $row['value'] }}</span>
                </div>
                @endforeach

                {{-- Deskripsi --}}
                <div>
                    <div style="font-size:0.82rem;color:#64748b;font-weight:600;margin-bottom:6px;">Deskripsi Masalah</div>
                    <div style="font-size:0.85rem;color:#374151;line-height:1.6;background:#f8fafc;padding:12px 16px;border-radius:10px;border:1px solid #e2e8f0;">
                        {{ $pengajuan->deskripsi ?? '-' }}
                    </div>
                </div>

                {{-- Alasan Tolak --}}
                @if($pengajuan->status === 'ditolak' && $pengajuan->alasan_tolak)
                <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:10px;padding:14px 16px;">
                    <div style="font-size:0.78rem;font-weight:700;color:#991b1b;margin-bottom:4px;">Alasan Penolakan</div>
                    <div style="font-size:0.85rem;color:#7f1d1d;line-height:1.5;">{{ $pengajuan->alasan_tolak }}</div>
                </div>
                @endif

                {{-- Reschedule --}}
                @if($pengajuan->status === 'reschedule' && $pengajuan->tanggal_reschedule)
                <div style="background:#ede9fe;border:1px solid #c4b5fd;border-radius:10px;padding:14px 16px;">
                    <div style="font-size:0.78rem;font-weight:700;color:#6d28d9;margin-bottom:8px;">Jadwal Baru (Reschedule)</div>
                    <div style="font-size:0.85rem;color:#4c1d95;font-weight:700;">
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_reschedule)->translatedFormat('d F Y') }}
                        &middot; {{ \Carbon\Carbon::parse($pengajuan->jam_reschedule)->format('H:i') }} WIB
                    </div>
                    @if($pengajuan->catatan_reschedule)
                    <div style="font-size:0.82rem;color:#5b21b6;margin-top:6px;">{{ $pengajuan->catatan_reschedule }}</div>
                    @endif
                </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
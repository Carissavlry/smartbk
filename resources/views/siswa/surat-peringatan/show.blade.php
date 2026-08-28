@extends('layouts.siswa')
@section('title', 'Surat Peringatan')
@section('page-title', 'Surat Peringatan')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    <div style="max-width:720px;margin:0 auto;">

        {{-- BACK --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <a href="{{ route('siswa.chat.index') }}"
                style="display:inline-flex;align-items:center;gap:6px;color:#64748b;text-decoration:none;font-size:0.82rem;font-weight:600;">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Chat
            </a>
            <a href="{{ route('siswa.surat-peringatan.download', $suratPeringatan->id) }}"
                style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#dc2626,#991b1b);color:white;padding:9px 18px;border-radius:10px;text-decoration:none;font-size:0.82rem;font-weight:700;box-shadow:0 4px 12px rgba(220,38,38,0.3);">
                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
        </div>

        {{-- SURAT --}}
        <div style="background:white;border-radius:16px;border:1.5px solid #fca5a5;box-shadow:0 2px 12px rgba(220,38,38,0.08);overflow:hidden;">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#dc2626,#991b1b);padding:24px 28px;display:flex;align-items:center;gap:14px;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;">
                    <svg style="width:26px;height:26px;" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:1.1rem;font-weight:800;color:white;margin:0;">Surat Peringatan</p>
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin:3px 0 0;">{{ $suratPeringatan->nomor_surat }}</p>
                </div>
                <div style="margin-left:auto;">
                    @php
                        $levelLabel = ['kuning'=>'SP-1 Kuning','merah'=>'SP-2 Merah','hitam'=>'SP-3 Hitam'];
                        $levelBg    = ['kuning'=>'#fef9c3','merah'=>'#fee2e2','hitam'=>'#1f2937'];
                        $levelColor = ['kuning'=>'#92400e','merah'=>'#991b1b','hitam'=>'#f9fafb'];
                    @endphp
                    <span style="background:{{ $levelBg[$suratPeringatan->level] }};color:{{ $levelColor[$suratPeringatan->level] }};font-size:0.78rem;font-weight:800;padding:5px 14px;border-radius:20px;">
                        {{ $levelLabel[$suratPeringatan->level] ?? $suratPeringatan->level }}
                    </span>
                </div>
            </div>

            {{-- Info --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;border-bottom:1px solid #fee2e2;">
                <div style="padding:16px 24px;border-right:1px solid #fee2e2;">
                    <p style="font-size:0.72rem;color:#94a3b8;font-weight:600;margin:0 0 4px;">Tanggal Surat</p>
                    <p style="font-size:0.88rem;font-weight:700;color:#0f172a;margin:0;">{{ \Carbon\Carbon::parse($suratPeringatan->tanggal_surat)->translatedFormat('d F Y') }}</p>
                </div>
                <div style="padding:16px 24px;">
                    <p style="font-size:0.72rem;color:#94a3b8;font-weight:600;margin:0 0 4px;">Total Poin Pelanggaran</p>
                    <p style="font-size:0.88rem;font-weight:700;color:#dc2626;margin:0;">{{ $suratPeringatan->total_poin }} poin</p>
                </div>
                <div style="padding:16px 24px;border-right:1px solid #fee2e2;border-top:1px solid #fee2e2;">
                    <p style="font-size:0.72rem;color:#94a3b8;font-weight:600;margin:0 0 4px;">Diterbitkan Oleh</p>
                    <p style="font-size:0.88rem;font-weight:700;color:#0f172a;margin:0;">{{ $suratPeringatan->guruBk->name ?? '-' }}</p>
                </div>
                <div style="padding:16px 24px;border-top:1px solid #fee2e2;">
                    <p style="font-size:0.72rem;color:#94a3b8;font-weight:600;margin:0 0 4px;">Status</p>
                    <span style="background:#dcfce7;color:#166534;font-size:0.75rem;font-weight:700;padding:3px 10px;border-radius:20px;">Sudah Diterima</span>
                </div>
            </div>

            {{-- Isi Surat --}}
            <div style="padding:24px 28px;">
                <p style="font-size:0.78rem;font-weight:700;color:#374151;margin:0 0 12px;text-transform:uppercase;letter-spacing:0.05em;">Isi Surat</p>
                <div style="background:#fef2f2;border-radius:12px;padding:18px 20px;border:1px solid #fecaca;">
                    <p style="font-size:0.88rem;color:#374151;line-height:1.8;margin:0;white-space:pre-line;">{{ $suratPeringatan->isi_surat }}</p>
                </div>
            </div>

            {{-- Catatan --}}
            @if($suratPeringatan->catatan)
            <div style="padding:0 28px 24px;">
                <p style="font-size:0.72rem;color:#94a3b8;font-weight:600;margin:0 0 6px;">Catatan</p>
                <p style="font-size:0.82rem;color:#64748b;margin:0;">{{ $suratPeringatan->catatan }}</p>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
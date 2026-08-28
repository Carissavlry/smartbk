@extends('layouts.siswa')
@section('title', 'Riwayat Konseling')
@section('page-title', 'Riwayat Konseling')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <h1 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0;">Riwayat Konseling</h1>
            <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Semua sesi konseling kamu bersama Guru BK</p>
        </div>
        <a href="{{ route('siswa.konseling.pengajuan') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);color:white;padding:10px 20px;border-radius:10px;text-decoration:none;font-size:0.85rem;font-weight:700;box-shadow:0 4px 12px rgba(30,58,95,0.3);">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Ajukan Konseling
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span style="font-size:0.85rem;color:#166534;font-weight:600;">{{ session('success') }}</span>
    </div>
    @endif

    {{-- CARD UTAMA --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">

        {{-- HEADER CARD --}}
        <div style="padding:18px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);border-radius:16px 16px 0 0;">
            <div style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                <svg style="width:17px;height:17px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <span style="font-size:0.9rem;font-weight:700;color:white;">Daftar Konseling</span>
            @php $totalItem = $total; @endphp
            <span style="margin-left:auto;background:rgba(255,255,255,0.2);color:white;font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:20px;">{{ $totalItem }} item</span>
        </div>

        @php $adaKonten = $paginator->count() > 0; @endphp

        @if(!$adaKonten)
        {{-- EMPTY STATE --}}
        <div style="text-align:center;padding:48px 20px;">
            <div style="width:64px;height:64px;border-radius:16px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <svg style="width:30px;height:30px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <p style="color:#94a3b8;font-size:0.85rem;font-weight:600;margin:0;">Belum ada riwayat konseling</p>
            <p style="color:#cbd5e1;font-size:0.78rem;margin:4px 0 16px;">Ajukan konseling pertamamu sekarang</p>
            <a href="{{ route('siswa.konseling.pengajuan') }}"
               style="display:inline-block;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);color:white;padding:9px 20px;border-radius:8px;text-decoration:none;font-size:0.82rem;font-weight:700;">
                Ajukan Sekarang
            </a>
        </div>
        @else

        @foreach($paginator as $item)
            @if($item->_type === 'pengajuan')
            <div style="padding:16px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:14px;border-left:4px solid {{ $item->status === 'ditolak' ? '#dc2626' : ($item->status === 'disetujui' ? '#16a34a' : ($item->status === 'reschedule' ? '#7c3aed' : '#ca8a04')) }};background:{{ $item->status === 'ditolak' ? '#fff5f5' : ($item->status === 'disetujui' ? '#f0fdf4' : ($item->status === 'reschedule' ? '#faf5ff' : '#fefce8')) }};" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <div style="width:42px;height:42px;border-radius:12px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:{{ $item->status === 'ditolak' ? '#fee2e2' : ($item->status === 'disetujui' ? '#dcfce7' : ($item->status === 'reschedule' ? '#ede9fe' : '#fef9c3')) }};">
                    @if($item->status === 'ditolak')
                        <svg style="width:20px;height:20px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    @elseif($item->status === 'disetujui')
                        <svg style="width:20px;height:20px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @elseif($item->status === 'reschedule')
                        <svg style="width:20px;height:20px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @else
                        <svg style="width:20px;height:20px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:0.88rem;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->topik }}</div>
                    <div style="font-size:0.78rem;color:#94a3b8;margin-top:2px;font-style:italic;">Pengajuan</div>
                    <div style="font-size:0.75rem;color:#64748b;margin-top:1px;">
                        {{ \Carbon\Carbon::parse($item->tanggal_diajukan)->translatedFormat('d F Y') }}
                        &middot; {{ \Carbon\Carbon::parse($item->jam_diajukan)->format('H:i') }} WIB
                    </div>
                </div>
                <span style="font-size:0.72rem;font-weight:700;padding:4px 12px;border-radius:20px;flex-shrink:0;background:{{ $item->status === 'ditolak' ? '#fee2e2' : ($item->status === 'disetujui' ? '#dcfce7' : ($item->status === 'reschedule' ? '#ede9fe' : '#fef9c3')) }};color:{{ $item->status === 'ditolak' ? '#991b1b' : ($item->status === 'disetujui' ? '#166534' : ($item->status === 'reschedule' ? '#6d28d9' : '#92400e')) }};">
                    {{ ucfirst($item->status) }}
                </span>
                <a href="{{ route('siswa.konseling.pengajuan.show', $item->id) }}"
                style="flex-shrink:0;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:8px;text-decoration:none;font-size:0.78rem;font-weight:600;">Detail</a>
            </div>

            @else
            <div style="padding:16px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:14px;border-left:4px solid {{ $item->status === 'Selesai' ? '#16a34a' : ($item->status === 'aktif' ? '#7c3aed' : '#ca8a04') }};background:{{ $item->status === 'Selesai' ? '#f0fdf4' : ($item->status === 'aktif' ? '#faf5ff' : '#fefce8') }};" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <div style="width:42px;height:42px;border-radius:12px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:{{ $item->status === 'Selesai' ? '#dcfce7' : ($item->status === 'aktif' ? '#ede9fe' : '#fef9c3') }};">
                    <svg style="width:20px;height:20px;" fill="none" stroke="{{ $item->status === 'Selesai' ? '#16a34a' : ($item->status === 'aktif' ? '#7c3aed' : '#ca8a04') }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:0.88rem;font-weight:700;color:#0f172a;">{{ $item->kategori ?? 'Konseling Umum' }}</div>
                    <div style="font-size:0.78rem;color:#94a3b8;margin-top:2px;font-style:italic;">Sesi Konseling</div>
                    <div style="font-size:0.75rem;color:#64748b;margin-top:1px;">
                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                        @if($item->guruBk) &middot; {{ $item->guruBk->name }} @endif
                    </div>
                </div>
                <span style="font-size:0.72rem;font-weight:700;padding:4px 12px;border-radius:20px;flex-shrink:0;background:{{ $item->status === 'Selesai' ? '#dcfce7' : ($item->status === 'aktif' ? '#ede9fe' : '#fef9c3') }};color:{{ $item->status === 'Selesai' ? '#166534' : ($item->status === 'aktif' ? '#6d28d9' : '#92400e') }};">
                    {{ ucfirst($item->status ?? '-') }}
                </span>
                <a href="{{ route('siswa.konseling.show', $item->id) }}"
                style="flex-shrink:0;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:8px;text-decoration:none;font-size:0.78rem;font-weight:600;">Detail</a>
            </div>
            @endif
        @endforeach

        {{-- PAGINATION --}}
        @if($paginator->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;">{{ $paginator->links() }}</div>
        @endif

        @endif{{-- end @if($adaKonten) --}}

    </div>{{-- END CARD UTAMA --}}

</div>
@endsection
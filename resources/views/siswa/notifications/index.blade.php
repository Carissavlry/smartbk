@extends('layouts.siswa')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <h1 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0;">Notifikasi</h1>
            <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Semua notifikasi aktivitas BK kamu</p>
        </div>
        @if($notifications->where('read_at', null)->count() > 0)
        <form method="POST" action="{{ route('siswa.notifications.read-all') }}">
            @csrf
            <button type="submit"
                style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);color:white;padding:9px 18px;border-radius:10px;border:none;font-size:0.82rem;font-weight:700;cursor:pointer;">
                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    {{-- LIST NOTIFIKASI --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">

        @forelse($notifications as $notif)
        @php
            $colors = [
                'konseling' => ['bg'=>'#ede9fe','icon'=>'#7c3aed','border'=>'#c4b5fd'],
                'warning'   => ['bg'=>'#fee2e2','icon'=>'#dc2626','border'=>'#fca5a5'],
                'info'      => ['bg'=>'#eff6ff','icon'=>'#2563eb','border'=>'#bfdbfe'],
                'success'   => ['bg'=>'#dcfce7','icon'=>'#16a34a','border'=>'#86efac'],
            ];
            $c = $colors[$notif->tipe] ?? $colors['info'];
        @endphp
        <a href="{{ route('siswa.notifications.read', $notif->id) }}"
            style="display:flex;align-items:flex-start;gap:14px;padding:16px 20px;border-bottom:1px solid #f1f5f9;text-decoration:none;background:{{ $notif->read_at ? 'white' : '#fafbff' }};"
            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='{{ $notif->read_at ? 'white' : '#fafbff' }}'">

            {{-- Icon --}}
            <div style="width:42px;height:42px;border-radius:12px;background:{{ $c['bg'] }};border:1px solid {{ $c['border'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                @if($notif->tipe === 'konseling')
                <svg style="width:20px;height:20px;" fill="none" stroke="{{ $c['icon'] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                @elseif($notif->tipe === 'warning')
                <svg style="width:20px;height:20px;" fill="none" stroke="{{ $c['icon'] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                @elseif($notif->tipe === 'success')
                <svg style="width:20px;height:20px;" fill="none" stroke="{{ $c['icon'] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                <svg style="width:20px;height:20px;" fill="none" stroke="{{ $c['icon'] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>

            {{-- Konten --}}
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                    <span style="font-size:0.88rem;font-weight:{{ $notif->read_at ? '600' : '800' }};color:#0f172a;">{{ $notif->judul }}</span>
                    @if(!$notif->read_at)
                    <span style="width:8px;height:8px;border-radius:50%;background:#2563eb;flex-shrink:0;display:inline-block;"></span>
                    @endif
                </div>
                <p style="font-size:0.8rem;color:#64748b;margin:0 0 6px;line-height:1.5;">{{ $notif->pesan }}</p>
                <span style="font-size:0.72rem;color:#94a3b8;">{{ $notif->created_at->setTimezone('Asia/Jakarta')->diffForHumans() }}</span>
            </div>
        </a>
        @empty
        <div style="text-align:center;padding:48px 0;">
            <svg fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="width:48px;height:48px;margin:0 auto 12px;display:block;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <p style="font-size:0.88rem;color:#94a3b8;font-weight:600;">Belum ada notifikasi</p>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($notifications->hasPages())
    <div style="margin-top:20px;">{{ $notifications->links() }}</div>
    @endif

</div>
@endsection
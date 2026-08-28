@extends('layouts.guru')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 style="font-size:1.4rem;font-weight:800;color:var(--navy-darkest);">Notifikasi</h1>
        @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('guru-bk.notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" style="font-size:0.82rem;color:var(--navy-mid);font-weight:600;background:none;border:none;cursor:pointer;">
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- List Notifikasi --}}
    @forelse($notifications as $notif)
        <a href="{{ route('guru-bk.notifications.read', $notif->id) }}"
            style="display:flex;align-items:flex-start;gap:14px;padding:16px;margin-bottom:10px;border-radius:12px;border:1px solid {{ $notif->read_at ? '#e2e8f0' : '#bfdbfe' }};background:{{ $notif->read_at ? '#ffffff' : '#eff6ff' }};text-decoration:none;transition:box-shadow 0.2s;"
            onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'"
            onmouseout="this.style.boxShadow='none'">

            {{-- Icon --}}
            <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
                background:{{ $notif->tipe === 'surat_peringatan' ? '#fee2e2' : ($notif->tipe === 'konseling' ? '#d1fae5' : '#dbeafe') }}">
                @if($notif->tipe === 'surat_peringatan')
                    <svg style="width:20px;height:20px;color:#dc2626;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z"/>
                    </svg>
                @elseif($notif->tipe === 'konseling')
                    <svg style="width:20px;height:20px;color:#059669;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                @else
                    {{-- sistem / chat --}}
                    <svg style="width:20px;height:20px;color:#2563eb;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>
                @endif
            </div>

            {{-- Konten --}}
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                    <p style="font-size:0.88rem;font-weight:700;color:var(--navy-darkest);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $notif->judul }}
                    </p>
                    @if(!$notif->read_at)
                        <span style="flex-shrink:0;width:10px;height:10px;border-radius:50%;background:#3b82f6;display:inline-block;"></span>
                    @endif
                </div>
                <p style="font-size:0.82rem;color:#64748b;margin-top:2px;">{{ $notif->pesan }}</p>
                <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">
                    {{ $notif->created_at->setTimezone('Asia/Jakarta')->diffForHumans() }}
                </p>
            </div>
        </a>
    @empty
        <div style="text-align:center;padding:64px 0;color:#94a3b8;">
            <div style="display:flex;justify-content:center;margin-bottom:16px;">
                <svg style="width:48px;height:48px;color:#cbd5e1;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
            </div>
            <p style="font-size:1rem;font-weight:600;">Belum ada notifikasi</p>
            <p style="font-size:0.82rem;margin-top:4px;">Notifikasi akan muncul di sini</p>
        </div>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

</div>
@endsection
@extends('layouts.siswa')

@section('title', 'Prestasi Saya')
@section('page-title', 'Prestasi Saya')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0;">Prestasi Saya</h1>
        <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Catatan prestasi yang dicatat oleh Guru BK</p>
    </div>

    {{-- SUMMARY CARDS --}}
    @php
        $akademik       = $prestasis->getCollection()->filter(fn($p) => $p->jenis === 'Akademik')->count();
        $nonAkademik    = $prestasis->getCollection()->filter(fn($p) => $p->jenis === 'Non-Akademik')->count();
        $juara1         = $prestasis->getCollection()->filter(fn($p) => $p->peringkat === 'Juara 1')->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
        {{-- Total Prestasi --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Total Prestasi</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $totalPrestasi }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Semua prestasi tercatat</div>
        </div>

        {{-- Akademik --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Akademik</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $akademik }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Prestasi bidang akademik</div>
        </div>

        {{-- Non-Akademik --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Non-Akademik</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $nonAkademik }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Prestasi non-akademik</div>
        </div>

        {{-- Juara 1 --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Juara 1</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $juara1 }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Prestasi peringkat pertama</div>
        </div>
    </div>

    {{-- DAFTAR PRESTASI --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
            <div style="width:28px;height:28px;border-radius:8px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
                <svg style="width:15px;height:15px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <span style="font-size:0.88rem;font-weight:700;color:#0f172a;">Daftar Prestasi</span>
            <span style="margin-left:auto;background:#f1f5f9;color:#64748b;font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:20px;">
                {{ $prestasis->total() }} prestasi
            </span>
        </div>

        @forelse($prestasis as $p)
        @php
            $jenisStyle = match($p->jenis ?? 'Akademik') {
                'Non-Akademik' => ['bg'=>'#dcfce7','color'=>'#166534','label'=>'Non-Akademik','icon'=>'#16a34a'],
                default        => ['bg'=>'#dbeafe','color'=>'#1e40af','label'=>'Akademik','icon'=>'#1d4ed8'],
            };
            $tingkatStyle = match($p->tingkat ?? 'Sekolah') {
                'Internasional' => ['bg'=>'#fef9c3','color'=>'#713f12','label'=>'Internasional'],
                'Nasional'      => ['bg'=>'#ede9fe','color'=>'#5b21b6','label'=>'Nasional'],
                'Provinsi'      => ['bg'=>'#dbeafe','color'=>'#1e40af','label'=>'Provinsi'],
                'Kota'          => ['bg'=>'#dcfce7','color'=>'#166534','label'=>'Kab/Kota'],
                'Kecamatan'     => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Kecamatan'],
                default         => ['bg'=>'#f1f5f9','color'=>'#475569','label'=>'Sekolah'],
            };
        @endphp

        <div style="padding:16px 20px;border-bottom:1px solid #f8fafc;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
            <div style="display:flex;align-items:flex-start;gap:14px;">
                {{-- Icon --}}
                <div style="width:42px;height:42px;border-radius:12px;background:{{ $jenisStyle['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:20px;height:20px;" fill="none" stroke="{{ $jenisStyle['icon'] }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>

                {{-- Detail --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
                        <span style="font-size:0.88rem;font-weight:700;color:#0f172a;">{{ $p->nama_prestasi }}</span>
                        <span style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $jenisStyle['bg'] }};color:{{ $jenisStyle['color'] }};">
                            {{ $jenisStyle['label'] }}
                        </span>
                        <span style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $tingkatStyle['bg'] }};color:{{ $tingkatStyle['color'] }};">
                            {{ $tingkatStyle['label'] }}
                        </span>
                        @if($p->peringkat)
                        <span style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#fef9c3;color:#713f12;">
                            <svg style="width:12px;height:12px;display:inline;vertical-align:middle;margin-right:2px;" fill="none" stroke="#713f12" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            {{ $p->peringkat }}
                        </span>
                        @endif
                    </div>

                    @if($p->keterangan)
                    <div style="font-size:0.8rem;color:#475569;margin-bottom:6px;line-height:1.5;">{{ $p->keterangan }}</div>
                    @endif

                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                        <span style="font-size:0.75rem;color:#94a3b8;">
                            <svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $p->tanggal->translatedFormat('d F Y') }}
                        </span>
                        @if($p->penyelenggara)
                        <span style="font-size:0.75rem;color:#94a3b8;"><svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>{{ $p->penyelenggara }}</span>
                        @endif
                        @if($p->pencatat)
                        <span style="font-size:0.75rem;color:#94a3b8;"><svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>{{ $p->pencatat->name }}</span>
                        @endif
                        @if($p->bukti)
                        <a href="{{ asset('storage/' . $p->bukti) }}" target="_blank"
                           style="font-size:0.75rem;color:#1d4ed8;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                            <svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>Lihat Bukti
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Badge Tingkat (kanan) --}}
                <div style="text-align:center;flex-shrink:0;min-width:52px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:20px;height:20px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <div style="font-size:0.68rem;color:#94a3b8;font-weight:600;letter-spacing:0.05em;">PRESTASI</div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:48px 20px;">
            <div style="width:64px;height:64px;border-radius:20px;background:#fef9c3;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg style="width:32px;height:32px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:4px;">Belum Ada Prestasi</div>
            <div style="font-size:0.82rem;color:#64748b;">Prestasimu akan muncul di sini setelah dicatat oleh Guru BK.</div>
        </div>
        @endforelse

        @if($prestasis->hasPages())
        <div style="padding:12px 20px;border-top:1px solid #f1f5f9;">
            {{ $prestasis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
@extends('layouts.siswa')
@section('title', 'Pengajuan Konseling')
@section('page-title', 'Pengajuan Konseling')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- HEADER --}}
    <a href="{{ route('siswa.konseling.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:0.82rem;text-decoration:none;padding:6px 10px;border-radius:8px;margin-bottom:14px;" onmouseover="this.style.background='#f1f5f9';this.style.color='#1e3a5f'" onmouseout="this.style.background='transparent';this.style.color='#64748b'">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Riwayat Konseling
    </a>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <h1 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0;">Pengajuan Konseling</h1>
            <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Ajukan jadwal konseling dengan Guru BK kamu</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:20px;">

        {{-- KIRI: Form Pengajuan --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- FORM --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#1e3a5f,#6b1d1d);padding:18px 24px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:17px;height:17px;" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </div>
                        <span style="font-size:0.95rem;font-weight:700;color:white;">Form Pengajuan Baru</span>
                    </div>
                </div>

                <form action="{{ route('siswa.konseling.pengajuan.store') }}" method="POST" style="padding:24px;">
                    @csrf

                    @if($errors->any())
                    <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:10px;padding:12px 16px;margin-bottom:20px;">
                        @foreach($errors->all() as $error)
                        <div style="font-size:0.82rem;color:#991b1b;font-weight:600;">• {{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Topik --}}
                    <div style="margin-bottom:18px;">
                        <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:6px;">
                            Topik Konseling <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="text" name="topik" value="{{ old('topik') }}"
                               placeholder="Contoh: Masalah belajar, Karir, Keluarga..."
                               style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.88rem;color:#0f172a;background:#f8fafc;box-sizing:border-box;outline:none;"
                               onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>

                    {{-- Deskripsi --}}
                    <div style="margin-bottom:18px;">
                        <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:6px;">
                            Deskripsi Masalah <span style="color:#dc2626;">*</span>
                        </label>
                        <textarea name="deskripsi" rows="4"
                                  placeholder="Ceritakan masalah atau topik yang ingin kamu konsultasikan..."
                                  style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.88rem;color:#0f172a;background:#f8fafc;box-sizing:border-box;resize:vertical;outline:none;font-family:inherit;"
                                  onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Tanggal & Jam --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px;">
                        <div>
                            <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:6px;">
                                Tanggal Diajukan <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="date" name="tanggal_diajukan" value="{{ old('tanggal_diajukan') }}"
                                   min="{{ date('Y-m-d') }}"
                                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.88rem;color:#0f172a;background:#f8fafc;box-sizing:border-box;outline:none;"
                                   onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:6px;">
                                Jam <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="time" name="jam_diajukan" value="{{ old('jam_diajukan') }}"
                                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.88rem;color:#0f172a;background:#f8fafc;box-sizing:border-box;outline:none;"
                                   onfocus="this.style.borderColor='#1e3a5f'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div style="display:flex;gap:12px;">
                        <button type="submit"
                                style="flex:1;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);color:white;padding:12px 20px;border:none;border-radius:10px;font-size:0.88rem;font-weight:700;cursor:pointer;">
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('siswa.konseling.index') }}"
                           style="padding:12px 20px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.88rem;font-weight:600;color:#475569;text-decoration:none;display:inline-flex;align-items:center;">
                            Batal
                        </a>
                    </div>
                </form>
           </div>
        </div>{{-- END KIRI --}}

        {{-- KANAN: Info --}}
        <div style="display:flex;flex-direction:column;gap:16px;">
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
                <div style="font-size:0.82rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">Info Pengajuan</div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:8px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div style="font-size:0.8rem;color:#475569;line-height:1.5;">Pengajuan akan direview oleh Guru BK kamu dalam 1x24 jam.</div>
                    </div>
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:8px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div style="font-size:0.8rem;color:#475569;line-height:1.5;">Jika disetujui, kamu akan mendapat notifikasi dan jadwal resmi.</div>
                    </div>
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:8px;background:#fef9c3;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div style="font-size:0.8rem;color:#475569;line-height:1.5;">Pilih tanggal minimal hari ini dan jam yang sesuai.</div>
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
                <div style="font-size:0.82rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">Statistik Pengajuan</div>
                @php
                    $totalPengajuan = $pengajuan->total();
                    $disetujui = $pengajuan->getCollection()->where('status','disetujui')->count();
                    $menunggu  = $pengajuan->getCollection()->where('status','menunggu')->count();
                    $ditolak   = $pengajuan->getCollection()->where('status','ditolak')->count();
                @endphp
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#f8fafc;border-radius:10px;">
                        <span style="font-size:0.82rem;color:#475569;font-weight:600;">Total Pengajuan</span>
                        <span style="font-size:0.9rem;font-weight:800;color:#0f172a;">{{ $totalPengajuan }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#dcfce7;border-radius:10px;">
                        <span style="font-size:0.82rem;color:#166534;font-weight:600;">Disetujui</span>
                        <span style="font-size:0.9rem;font-weight:800;color:#166534;">{{ $disetujui }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fef9c3;border-radius:10px;">
                        <span style="font-size:0.82rem;color:#92400e;font-weight:600;">Menunggu</span>
                        <span style="font-size:0.9rem;font-weight:800;color:#92400e;">{{ $menunggu }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fee2e2;border-radius:10px;">
                        <span style="font-size:0.82rem;color:#991b1b;font-weight:600;">Ditolak</span>
                        <span style="font-size:0.9rem;font-weight:800;color:#991b1b;">{{ $ditolak }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
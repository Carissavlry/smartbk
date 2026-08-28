<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Identitas — {{ $siswa->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'Inter',Arial,sans-serif;
            background: linear-gradient(270deg, #C1E8FF 0%, #7DA0CA 20%, #5483B3 45%, #2E1760 65%, #6B1228 85%, #3d0a18 100%);
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:32px;
            padding:40px 20px;
        }

        .page-title {
            color:rgba(255,255,255,0.5);
            font-size:0.7rem;
            font-weight:700;
            letter-spacing:4px;
            text-transform:uppercase;
        }

        .cards-wrapper {
            display:flex;
            gap:40px;
            align-items:flex-start;
            flex-wrap:wrap;
            justify-content:center;
        }

        .card-container {
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:12px;
        }

        .card-label {
            color:rgba(255,255,255,0.35);
            font-size:0.65rem;
            font-weight:700;
            text-transform:uppercase;
            letter-spacing:3px;
        }

        /* KTP size */
        .card {
            width:340px;
            height:214px;
            border-radius:16px;
            overflow:hidden;
            position:relative;
            box-shadow:
                0 25px 70px rgba(0,0,0,0.7),
                0 8px 24px rgba(117,22,46,0.3),
                inset 0 1px 0 rgba(255,255,255,0.1);
        }

        /* ===== DEPAN ===== */
        .card-front {
            background: linear-gradient(135deg, #021024 0%, #052659 40%, #0a1e4a 70%, #021024 100%);
            display:flex;
            flex-direction:column;
        }

        /* Geometric diagonal accent */
        .card-front::before {
            content:'';
            position:absolute;
            top:0; right:0;
            width:160px; height:100%;
            background: linear-gradient(135deg, transparent 0%, rgba(117,22,46,0.08) 50%, rgba(117,22,46,0.15) 100%);
            clip-path: polygon(40% 0%, 100% 0%, 100% 100%, 0% 100%);
            pointer-events:none;
            z-index:1;
        }

        /* Top glow orb */
        .card-front::after {
            content:'';
            position:absolute;
            top:-40px; right:-40px;
            width:140px; height:140px;
            border-radius:50%;
            background: radial-gradient(circle, rgba(117,22,46,0.4) 0%, transparent 70%);
            pointer-events:none;
            z-index:1;
        }

        /* Header */
        .front-header {
            position:relative;
            z-index:3;
            padding:0;
            flex-shrink:0;
            overflow:hidden;
        }

        .header-bg {
            background: linear-gradient(90deg, #75162E 0%, #9B1B37 40%, #75162E 70%, #3d0a18 100%);
            padding:7px 12px;
            display:flex;
            align-items:center;
            gap:9px;
            position:relative;
        }

        /* Diagonal cut bottom */
        .header-bg::after {
            content:'';
            position:absolute;
            bottom:-8px; left:0; right:0;
            height:10px;
            background: linear-gradient(90deg, #75162E, #9B1B37, #75162E, #3d0a18);
            clip-path: polygon(0 0, 100% 0, 100% 30%, 0 100%);
        }

        .logo-wrap {
            width:36px; height:36px;
            border-radius:6px;
            overflow:hidden;
            flex-shrink:0;
            background:rgba(255,255,255,0.1);
            display:flex;
            align-items:center;
            justify-content:center;
            border:1.5px solid rgba(255,255,255,0.2);
        }

        .logo-wrap img {
            width:100%; height:100%;
            object-fit:contain;
            filter:brightness(1.1);
        }

        .school-info { flex:1; min-width:0; }

        .school-name {
            color:white;
            font-size:0.58rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:0.3px;
            line-height:1.2;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .school-address {
            color:rgba(255,255,255,0.65);
            font-size:0.38rem;
            line-height:1.3;
            margin-top:1px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .kartu-badge {
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.08));
            border:1px solid rgba(255,255,255,0.25);
            color:white;
            font-size:0.38rem;
            font-weight:800;
            padding:3px 8px;
            border-radius:20px;
            text-transform:uppercase;
            letter-spacing:1px;
            white-space:nowrap;
            backdrop-filter:blur(4px);
            flex-shrink:0;
        }

        /* Thin accent line below header */
        .header-accent {
            height:3px;
            background: linear-gradient(90deg, #FFD700 0%, #FFA500 30%, #FF6B35 60%, #75162E 100%);
            position:relative;
            z-index:3;
            flex-shrink:0;
        }

        /* Body */
        .front-body {
            flex:1;
            display:flex;
            padding:10px 12px 8px 12px;
            gap:10px;
            position:relative;
            z-index:3;
        }

        /* Foto */
        .foto-frame {
            width:62px;
            height:76px;
            border-radius:8px;
            overflow:hidden;
            flex-shrink:0;
            border:2px solid rgba(255,215,0,0.4);
            background:linear-gradient(135deg, #0a1e3d, #1a0a1e);
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:
                0 4px 16px rgba(0,0,0,0.5),
                inset 0 0 0 1px rgba(255,255,255,0.05);
            position:relative;
        }

        .foto-frame::before {
            content:'';
            position:absolute;
            top:0; left:0; right:0;
            height:2px;
            background: linear-gradient(90deg, #FFD700, #FFA500);
            border-radius:8px 8px 0 0;
        }

        .foto-frame img {
            width:100%; height:100%;
            object-fit:cover;
        }

        .foto-frame .no-foto {
            color:rgba(255,255,255,0.25);
            font-size:0.35rem;
            text-align:center;
        }

        /* Info */
        .info-wrap {
            flex:1;
            display:flex;
            flex-direction:column;
            min-width:0;
        }

        .student-name {
            color:#FFD700;
            font-size:0.7rem;
            font-weight:900;
            text-transform:uppercase;
            letter-spacing:0.5px;
            line-height:1.2;
            margin-bottom:6px;
            text-shadow: 0 0 20px rgba(255,215,0,0.3);
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .info-grid {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:3px 8px;
        }

        .info-row { display:flex; flex-direction:column; }

        .info-row.full { grid-column:1/-1; }

        .info-label {
            color:rgba(193,232,255,0.45);
            font-size:0.34rem;
            font-weight:700;
            text-transform:uppercase;
            letter-spacing:0.5px;
        }

        .info-value {
            color:rgba(255,255,255,0.9);
            font-size:0.5rem;
            font-weight:600;
            line-height:1.3;
        }

        /* QR */
        .qr-wrap {
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:4px;
            flex-shrink:0;
        }

        .qr-box {
            background:white;
            padding:4px;
            border-radius:8px;
            box-shadow:0 4px 16px rgba(0,0,0,0.4);
            border:2px solid rgba(255,215,0,0.3);
        }

        .qr-box svg, .qr-box img {
            width:52px; height:52px;
            display:block;
        }

        .qr-caption {
            color:rgba(193,232,255,0.5);
            font-size:0.33rem;
            text-align:center;
            line-height:1.4;
        }

        /* Footer depan */
        .front-footer {
            position:relative;
            z-index:3;
            flex-shrink:0;
        }

        .footer-accent {
            height:3px;
            background: linear-gradient(90deg, #75162E 0%, #FF6B35 30%, #FFA500 60%, #FFD700 100%);
        }

        .footer-bar {
            background: linear-gradient(90deg, #3d0a18 0%, #75162E 40%, #9B1B37 60%, #3d0a18 100%);
            height:16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 12px;
        }

        .footer-text {
            color:rgba(255,255,255,0.6);
            font-size:0.32rem;
            letter-spacing:2px;
            text-transform:uppercase;
            font-weight:600;
        }

        .footer-dots {
            display:flex;
            gap:3px;
        }

        .footer-dot {
            width:4px; height:4px;
            border-radius:50%;
        }

        .dot-gold { background:#FFD700; opacity:0.8; }
        .dot-white { background:white; opacity:0.4; }
        .dot-red { background:#FF6B35; opacity:0.8; }

        /* ===== BELAKANG ===== */
        .card-back {
            background: linear-gradient(145deg, #021024 0%, #0d0520 40%, #052659 70%, #1a0a1e 100%);
            display:flex;
            flex-direction:column;
            position:relative;
        }

        /* Geometric bg pattern */
        .card-back::before {
            content:'';
            position:absolute;
            bottom:-30px; left:-30px;
            width:150px; height:150px;
            border-radius:50%;
            background: radial-gradient(circle, rgba(117,22,46,0.25) 0%, transparent 70%);
            pointer-events:none;
        }

        .card-back::after {
            content:'';
            position:absolute;
            top:-20px; right:40px;
            width:100px; height:100px;
            border-radius:50%;
            background: radial-gradient(circle, rgba(5,38,89,0.4) 0%, transparent 70%);
            pointer-events:none;
        }

        .back-header {
            background: linear-gradient(90deg, #75162E 0%, #9B1B37 50%, #75162E 100%);
            padding:7px 14px;
            flex-shrink:0;
            position:relative;
            z-index:2;
        }

        .back-header::after {
            content:'';
            position:absolute;
            bottom:-3px; left:0; right:0;
            height:3px;
            background: linear-gradient(90deg, #FFD700, #FFA500, #FF6B35, #75162E);
        }

        .back-header-title {
            color:white;
            font-size:0.5rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:1.5px;
            text-align:center;
        }

        .back-body {
            flex:1;
            padding:10px 14px 6px;
            display:flex;
            flex-direction:column;
            gap:1px;
            position:relative;
            z-index:2;
        }

        .back-section-title {
            color:rgba(255,215,0,0.7);
            font-size:0.38rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:1px;
            margin-bottom:5px;
            padding-bottom:3px;
            border-bottom:1px solid rgba(255,215,0,0.15);
        }

        .back-item {
            display:flex;
            gap:6px;
            margin-bottom:3px;
            align-items:flex-start;
        }

        .back-num {
            color:#FF6B35;
            font-size:0.42rem;
            font-weight:800;
            flex-shrink:0;
            width:10px;
            line-height:1.5;
        }

        .back-text {
            color:rgba(255,255,255,0.78);
            font-size:0.41rem;
            line-height:1.5;
        }

        .back-footer {
            background: linear-gradient(90deg, rgba(117,22,46,0.3), rgba(5,38,89,0.4), rgba(117,22,46,0.3));
            padding:5px 14px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            border-top:1px solid rgba(255,215,0,0.15);
            flex-shrink:0;
            position:relative;
            z-index:2;
        }

        .back-footer-left { display:flex; flex-direction:column; }

        .back-footer-school {
            color:#C1E8FF;
            font-size:0.42rem;
            font-weight:700;
        }

        .back-footer-sub {
            color:rgba(193,232,255,0.4);
            font-size:0.35rem;
        }

        .back-footer-year {
            color:rgba(255,215,0,0.7);
            font-size:0.42rem;
            font-weight:700;
        }

        /* ===== ACTIONS ===== */
        .actions {
            display:flex;
            gap:12px;
            margin-top:4px;
        }

        .btn {
            padding:11px 28px;
            border-radius:12px;
            border:none;
            cursor:pointer;
            font-size:0.875rem;
            font-weight:700;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap:8px;
            transition:all 0.2s;
            font-family:'Inter',Arial,sans-serif;
        }

        .btn-print {
            background: linear-gradient(135deg, #75162E, #9B1B37);
            color:white;
            box-shadow:0 4px 20px rgba(117,22,46,0.5);
        }

        .btn-print:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(117,22,46,0.6); }

        .btn-back {
            background:rgba(255,255,255,0.08);
            color:white;
            border:1px solid rgba(255,255,255,0.2);
            backdrop-filter:blur(8px);
        }

        .btn-back:hover { background:rgba(255,255,255,0.15); }

        @media print {
            @page { size:A4 portrait; margin:15mm; }
            * { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
            body { background:white !important; padding:0 !important; gap:15mm !important; }
            .page-title, .card-label, .actions { display:none !important; }
            .cards-wrapper { gap:10mm !important; }
            .card { box-shadow:none !important; border:1px solid #ccc !important; }
        }
    </style>
</head>
<body>

<div class="page-title">Kartu Identitas Siswa — Depan &amp; Belakang</div>

<div class="cards-wrapper">

    {{-- ===== DEPAN ===== --}}
    <div class="card-container">
        <div class="card-label">Depan</div>
        <div class="card card-front">

            <div class="front-header">
                <div class="header-bg">
                    @if($config->logo)
                        <div class="logo-wrap">
                            <img src="{{ asset('storage/' . $config->logo) }}" alt="Logo">
                        </div>
                    @else
                        <div class="logo-wrap">
                            <span style="color:white;font-size:0.55rem;font-weight:900;">BK</span>
                        </div>
                    @endif
                    <div class="school-info">
                        <div class="school-name">{{ $config->nama_sekolah ?? 'SmartBK' }}</div>
                        <div class="school-address">{{ $config->alamat_sekolah ?? 'Sistem Informasi Bimbingan Konseling' }}</div>
                    </div>
                    <div class="kartu-badge">Kartu Pelajar</div>
                </div>
            </div>

            <div class="header-accent"></div>

            <div class="front-body">

                {{-- Foto --}}
                <div class="foto-frame">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto">
                    @else
                        <div class="no-foto">Tidak Ada<br>Foto</div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="info-wrap">
                    <div class="student-name">{{ $siswa->name }}</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">NIS</span>
                            <span class="info-value">{{ $siswa->nis }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kelas</span>
                            <span class="info-value">{{ $siswa->kelas->nama ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-value">{{ $siswa->jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Agama</span>
                            <span class="info-value">{{ $siswa->agama ?? '-' }}</span>
                        </div>
                        <div class="info-row full">
                            <span class="info-label">TTL</span>
                            <span class="info-value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- QR --}}
                <div class="qr-wrap">
                    <div class="qr-box">{!! $qrCode !!}</div>
                    <div class="qr-caption">Scan untuk<br>profil lengkap</div>
                </div>

            </div>

            <div class="front-footer">
                <div class="footer-accent"></div>
                <div class="footer-bar">
                    <span class="footer-text">SmartBK — Bimbingan Konseling</span>
                    <div class="footer-dots">
                        <div class="footer-dot dot-gold"></div>
                        <div class="footer-dot dot-white"></div>
                        <div class="footer-dot dot-red"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== BELAKANG ===== --}}
    <div class="card-container">
        <div class="card-label">Belakang</div>
        <div class="card card-back">

            <div class="back-header">
                <div class="back-header-title">⬥ Syarat &amp; Ketentuan Penggunaan Kartu ⬥</div>
            </div>

            <div class="back-body">
                <div class="back-section-title">Kartu ini berlaku untuk:</div>
                <div class="back-item">
                    <span class="back-num">1.</span>
                    <span class="back-text">Identitas resmi siswa di lingkungan sekolah.</span>
                </div>
                <div class="back-item">
                    <span class="back-num">2.</span>
                    <span class="back-text">Keperluan administrasi dan layanan BK.</span>
                </div>
                <div class="back-item">
                    <span class="back-num">3.</span>
                    <span class="back-text">Kartu tidak berlaku jika digunakan oleh selain pemilik yang tertera.</span>
                </div>
                <div class="back-item">
                    <span class="back-num">4.</span>
                    <span class="back-text">Dilarang meminjamkan atau memindahtangankan kartu kepada pihak lain.</span>
                </div>
                <div class="back-item">
                    <span class="back-num">5.</span>
                    <span class="back-text">Jika hilang atau rusak, segera laporkan ke Admin Sekolah.</span>
                </div>
                <div class="back-item">
                    <span class="back-num">6.</span>
                    <span class="back-text">Kartu ini adalah milik sekolah dan wajib dikembalikan saat lulus.</span>
                </div>
            </div>

            <div class="back-footer">
                <div class="back-footer-left">
                    <span class="back-footer-school">{{ $config->nama_sekolah ?? 'SmartBK' }}</span>
                    <span class="back-footer-sub">Bimbingan Konseling</span>
                </div>
                <span class="back-footer-year">T.A. {{ date('Y') }}/{{ date('Y')+1 }}</span>
            </div>

        </div>
    </div>

</div>

<div class="actions">
        @if(auth()->user()->hasRole('guru_bk'))
            <a href="{{ route('guru-bk.siswa-binaan.show', $siswa) }}" class="btn btn-back">
        @else
            <a href="{{ route('admin.siswa.show', $siswa) }}" class="btn btn-back">
        @endif
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <button onclick="window.print()" class="btn btn-print">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Cetak Kartu
    </button>
</div>

</body>
</html>
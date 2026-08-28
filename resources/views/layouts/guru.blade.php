<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartBK') — Guru BK</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy-darkest: #021024;
            --navy-dark:    #052659;
            --navy-mid:     #5483B3;
            --navy-light:   #7DA0CA;
            --navy-pale:    #C1E8FF;
            --maroon-dark:  #3A000C;
            --maroon-mid:   #75162E;
            --maroon-soft:  #550B18;
            --white:        #ffffff;
            --gray-bg:      #f1f5f9;
            --sidebar-w:    260px;
            --sidebar-w-collapsed: 70px;
            --topbar-h:     64px;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: var(--gray-bg);
            color: var(--navy-darkest);
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(160deg, var(--navy-darkest) 0%, var(--navy-dark) 55%, var(--maroon-soft) 100%);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: width 0.3s ease;
            overflow: hidden;
        }
        .sidebar.collapsed { width: var(--sidebar-w-collapsed); }

        /* Brand */
        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            padding: 20px 18px 16px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }
        .sidebar-brand__icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--maroon-mid), var(--maroon-dark));
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1rem; font-weight: 900;
            flex-shrink: 0;
        }
        .sidebar-brand__text { display: flex; flex-direction: column; overflow: hidden; }
        .sidebar-brand__name { font-size: 1rem; font-weight: 800; color: white; white-space: nowrap; }
        .sidebar-brand__sub { font-size: 0.62rem; color: var(--navy-light); letter-spacing: 0.06em; text-transform: uppercase; white-space: nowrap; }

        /* Nav */
        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-section-label {
            padding: 10px 20px 4px;
            font-size: 0.6rem; font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase; letter-spacing: 0.1em;
            white-space: nowrap; overflow: hidden;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .nav-section-label { opacity: 0; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 18px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.83rem; font-weight: 500;
            transition: all 0.2s;
            position: relative;
            white-space: nowrap;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: white; }
        .nav-item.active {
            background: rgba(117,22,46,0.3);
            color: white;
            border-right: 3px solid var(--maroon-mid);
        }
        .nav-item__icon { width: 20px; height: 20px; flex-shrink: 0; display:flex; align-items:center; justify-content:center; }
        .nav-item__icon svg { width: 18px; height: 18px; }
        .nav-item__label { overflow: hidden; transition: opacity 0.2s, width 0.2s; }
        .sidebar.collapsed .nav-item__label { opacity: 0; width: 0; }

        /* Tooltip collapsed */
        .sidebar.collapsed .nav-item:hover::after {
            content: attr(data-label);
            position: absolute;
            left: calc(var(--sidebar-w-collapsed) + 8px);
            top: 50%; transform: translateY(-50%);
            background: var(--navy-dark);
            color: white; padding: 6px 12px;
            border-radius: 8px; font-size: 0.78rem;
            white-space: nowrap; z-index: 200;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        .sidebar-user { display: flex; align-items: center; gap: 10px; }
        .sidebar-user__avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, var(--maroon-mid), var(--maroon-dark));
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.82rem; font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-user__info { overflow: hidden; transition: opacity 0.2s, width 0.2s; }
        .sidebar.collapsed .sidebar-user__info { opacity: 0; width: 0; }
        .sidebar-user__name { font-size: 0.76rem; font-weight: 600; color: white; white-space: nowrap; }
        .sidebar-user__role { font-size: 0.62rem; color: var(--navy-light); white-space: nowrap; }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0; left: var(--sidebar-w); right: 0;
            height: var(--topbar-h);
            background: linear-gradient(135deg, var(--navy-darkest) 0%, var(--navy-dark) 60%, var(--maroon-soft) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 90;
            transition: left 0.3s ease;
            box-shadow: 0 2px 8px rgba(2,16,36,0.25);
        }
        .topbar.collapsed { left: var(--sidebar-w-collapsed); }

        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .btn-toggle {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(255,255,255,0.08); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--white); transition: background 0.2s;
        }
        .btn-toggle:hover { background: rgba(255,255,255,0.15); }
        .topbar-title { font-size: 0.95rem; font-weight: 700; color: var(--white); }

        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-user { display: flex; align-items: center; gap: 8px; }
        .topbar-user__avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, var(--maroon-mid), var(--maroon-dark));
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.82rem; font-weight: 700;
        }
        .topbar-user__name { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.85); }

        .btn-logout {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px;
            background: var(--maroon-mid);
            color: var(--white); border: none; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: background 0.2s;
        }
        .btn-logout:hover { background: var(--maroon-dark); color: white; }
        .btn-logout svg { width: 15px; height: 15px; }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 28px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--topbar-h));
        }
        .main-content.collapsed { margin-left: var(--sidebar-w-collapsed); }

        /* ===== MOBILE OVERLAY ===== */
        .mobile-overlay {
            display: none; position: fixed;
            inset: 0; background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        .mobile-overlay.active { display: block; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.mobile-open { transform: translateX(0); }
            .topbar { left: 0 !important; }
            .main-content { margin-left: 0 !important; }
        }
    </style>
</head>
<body>

<div class="mobile-overlay" id="mobileOverlay"></div>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar" id="sidebar">

    <!-- Brand -->
    <a href="{{ route('guru-bk.dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand__icon">S</div>
        <div class="sidebar-brand__text">
            <span class="sidebar-brand__name">SmartBK</span>
            <span class="sidebar-brand__sub">Guru BK</span>
        </div>
    </a>

    <!-- Nav -->
    <nav class="sidebar-nav">

        <div class="nav-section-label">Utama</div>

        <a href="{{ route('guru-bk.dashboard') }}"
           class="nav-item {{ request()->routeIs('guru-bk.dashboard') ? 'active' : '' }}"
           data-label="Dashboard">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </span>
            <span class="nav-item__label">Dashboard</span>
        </a>

        <div class="nav-section-label">Data Siswa</div>

        <a href="{{ route('guru-bk.siswa-binaan.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.siswa-binaan.*') ? 'active' : '' }}"
            data-label="Data Siswa Binaan">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </span>
            <span class="nav-item__label">Data Siswa Binaan</span>
        </a>

        <div class="nav-section-label">Konseling</div>

        <a href="{{ route('guru-bk.konseling.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.konseling.*') ? 'active' : '' }}"
            data-label="Sesi Konseling">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                </svg>
            </span>
            <span class="nav-item__label">Sesi Konseling</span>
        </a>

        <a href="{{ route('guru-bk.konseling-pengajuan.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.konseling-pengajuan.*') ? 'active' : '' }}"
            data-label="Pengajuan Konseling">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                </svg>
            </span>
            <span class="nav-item__label">Pengajuan Konseling</span>
        </a>

        <a href="{{ route('guru-bk.pelanggaran.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.pelanggaran.*') ? 'active' : '' }}"
            data-label="Pelanggaran & Poin">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                </svg>
            </span>
            <span class="nav-item__label">Pelanggaran & Poin</span>
        </a>

        <a href="{{ route('guru-bk.home-visit.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.home-visit.*') ? 'active' : '' }}"
            data-label="Home Visit">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </span>
            <span class="nav-item__label">Home Visit</span>
        </a>

        <a href="{{ route('guru-bk.prestasi.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.prestasi.*') ? 'active' : '' }}"
            data-label="Prestasi Siswa">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </span>
            <span class="nav-item__label">Prestasi Siswa</span>
        </a>

        <a href="{{ route('guru-bk.surat-peringatan.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.surat-peringatan.*') ? 'active' : '' }}"
            data-label="Surat Peringatan">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z"/>
                </svg>
            </span>
            <span class="nav-item__label">Surat Peringatan</span>
        </a>

        <a href="{{ route('guru-bk.chat.index') }}"
        class="nav-item {{ request()->routeIs('guru-bk.chat.*') ? 'active' : '' }}"
        data-label="Chat Siswa">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                </svg>
            </span>
            <span class="nav-item__label">Chat Siswa</span>
        </a>

        <a href="{{ route('guru-bk.pengumuman.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.pengumuman.*') ? 'active' : '' }}"
            data-label="Papan Pengumuman">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                </svg>
            </span>
            <span class="nav-item__label">Papan Pengumuman</span>
        </a>

        <div class="nav-section-label">Akun</div>

        <a href="{{ route('guru-bk.profil.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.profil.*') ? 'active' : '' }}"
            data-label="Profil Saya">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </span>
            <span class="nav-item__label">Profil Saya</span>
        </a>

        <div class="nav-section-label">Laporan</div>

        <a href="{{ route('guru-bk.laporan.index') }}"
            class="nav-item {{ request()->routeIs('guru-bk.laporan.*') ? 'active' : '' }}"
            data-label="Laporan">
            <span class="nav-item__icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </span>
            <span class="nav-item__label">Laporan</span>
        </a>

    </nav>

    <!-- Footer User -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user__avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user__info">
                <div class="sidebar-user__name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user__role">Guru BK</div>
            </div>
        </div>
    </div>
</aside>

<!-- ===== TOPBAR ===== -->
<header class="topbar" id="topbar">
    <div class="topbar-left">
        <button class="btn-toggle" id="sidebarToggle">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    </div>
    <div class="topbar-right">
        {{-- Bell Notification --}}
        <div style="position:relative;" id="notifWrapper">
            <button id="notifBtn" onclick="toggleNotifDropdown()"
                style="position:relative;width:38px;height:38px;border-radius:9px;background:rgba(255,255,255,0.08);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;transition:background 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="width:20px;height:20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
                {{-- Badge --}}
                <span id="notifBadge"
                    style="display:none;position:absolute;top:4px;right:4px;min-width:18px;height:18px;border-radius:9px;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;line-height:18px;text-align:center;padding:0 4px;">
                    0
                </span>
            </button>

            {{-- Dropdown --}}
            <div id="notifDropdown"
                style="display:none;position:absolute;top:48px;right:0;width:340px;background:white;border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,0.18);z-index:999;overflow:hidden;">

                {{-- Header Dropdown --}}
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:0.88rem;font-weight:700;color:#0f172a;">Notifikasi</span>
                    <a href="{{ route('guru-bk.notifications.read-all') }}"
                        id="markAllBtn"
                        onclick="markAllRead(event)"
                        style="font-size:0.75rem;color:#3b82f6;font-weight:600;text-decoration:none;">
                        Tandai Semua Dibaca
                    </a>
                </div>

                {{-- List --}}
                <div id="notifList" style="max-height:340px;overflow-y:auto;">
                    <div style="text-align:center;padding:32px 0;color:#94a3b8;">
                        <svg style="width:32px;height:32px;margin:0 auto 8px;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                        <p style="font-size:0.82rem;">Tidak ada notifikasi baru</p>
                    </div>
                </div>

                {{-- Footer --}}
                <a href="{{ route('guru-bk.notifications.index') }}"
                    style="display:block;text-align:center;padding:12px;border-top:1px solid #f1f5f9;font-size:0.8rem;color:#3b82f6;font-weight:600;text-decoration:none;background:#fafafa;">
                    Lihat Semua Notifikasi
                </a>
            </div>
        </div>
        <div class="topbar-user">
            <div class="topbar-user__avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="topbar-user__name">{{ auth()->user()->name }}</span>
        </div>
        <button type="submit" form="logout-form" class="btn-logout">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
        </button>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
    </div>
</header>

<!-- ===== MAIN CONTENT ===== -->
<main class="main-content" id="mainContent">
    @yield('content')
</main>

@stack('scripts')

{{-- ===== TOAST CONTAINER ===== --}}
<div id="toastContainer" style="position:fixed;top:72px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

<script>
// ===== NOTIFIKASI GURU BK =====
const notifBadge    = document.getElementById('notifBadge');
const notifDropdown = document.getElementById('notifDropdown');
const notifList     = document.getElementById('notifList');

const NOTIF_URL  = '{{ route("guru-bk.notifications.unread") }}';
const READ_BASE  = '{{ url("/guru-bk/notifications") }}';

let seenIds      = new Set(JSON.parse(sessionStorage.getItem('guru_seen_notif_ids') || '[]'));
let isFirstFetch = sessionStorage.getItem('guru_notif_initialized') !== 'true';
let lastData     = { count: 0, items: [] };

const icons = {
    konseling        : `<svg style="width:18px;height:18px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>`,
    warning          : `<svg style="width:18px;height:18px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>`,
    success          : `<svg style="width:18px;height:18px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    info             : `<svg style="width:18px;height:18px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    chat             : `<svg style="width:18px;height:18px;" fill="none" stroke="#0891b2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 14.103 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>`,
    alert_pelanggaran: `<svg style="width:18px;height:18px;" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>`,
};
const bgColors  = { konseling:'#ede9fe', warning:'#fee2e2', success:'#dcfce7', info:'#eff6ff', chat:'#cffafe', alert_pelanggaran:'#fef3c7' };
const dotColors = { konseling:'#7c3aed', warning:'#dc2626', success:'#16a34a', info:'#2563eb', chat:'#0891b2', alert_pelanggaran:'#b45309' };

// ===== TOGGLE DROPDOWN =====
function toggleNotifDropdown() {
    const isOpen = notifDropdown.style.display === 'block';
    notifDropdown.style.display = isOpen ? 'none' : 'block';
    if (!isOpen) renderDropdown(lastData);
}

document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('notifWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        notifDropdown.style.display = 'none';
    }
});

// ===== TOAST =====
function showToast(notif) {
    const container = document.getElementById('toastContainer');
    const bg  = bgColors[notif.tipe]  || bgColors.info;
    const ico = icons[notif.tipe]     || icons.info;
    const dot = dotColors[notif.tipe] || dotColors.info;
    const readUrl = `${READ_BASE}/${notif.id}/read`;

    const toast = document.createElement('div');
    toast.style.cssText = `
        pointer-events:all;
        min-width:300px;max-width:360px;
        background:white;border-radius:14px;
        box-shadow:0 8px 32px rgba(0,0,0,0.18);
        border-left:4px solid ${dot};
        display:flex;align-items:flex-start;gap:12px;
        padding:14px 16px;cursor:pointer;
        animation:slideInRight 0.35s ease;
        position:relative;overflow:hidden;
    `;
    toast.setAttribute('data-toast', notif.id);
    toast.innerHTML = `
        <div style="width:36px;height:36px;border-radius:10px;background:${bg};display:flex;align-items:center;justify-content:center;flex-shrink:0;">${ico}</div>
        <div style="flex:1;min-width:0;">
            <div style="font-size:0.82rem;font-weight:700;color:#0f172a;margin-bottom:3px;">${notif.judul}</div>
            <div style="font-size:0.75rem;color:#64748b;line-height:1.4;">${notif.pesan}</div>
            <div style="font-size:0.68rem;color:#94a3b8;margin-top:4px;">${notif.waktu}</div>
        </div>
        <button onclick="event.stopPropagation();dismissToast(this.closest('[data-toast]'))"
            style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;font-size:1rem;line-height:1;flex-shrink:0;">&#x2715;</button>
        <div class="toast-progress" style="position:absolute;bottom:0;left:0;height:3px;background:${dot};width:100%;transition:width 8s linear;"></div>
    `;
    toast.addEventListener('click', () => { window.location.href = readUrl; });
    container.appendChild(toast);

    setTimeout(() => {
        const bar = toast.querySelector('.toast-progress');
        if (bar) bar.style.width = '0%';
    }, 50);

    const timer = setTimeout(() => dismissToast(toast), 8000);
    toast._timer = timer;
}

function dismissToast(toast) {
    if (!toast) return;
    clearTimeout(toast._timer);
    toast.style.animation = 'slideOutRight 0.3s ease forwards';
    setTimeout(() => toast.remove(), 300);
}

// ===== RENDER DROPDOWN =====
function renderDropdown(data) {
    const badge = document.getElementById('notifBadge');
    badge.style.display = data.count > 0 ? 'block' : 'none';
    badge.textContent   = data.count > 99 ? '99+' : data.count;

    if (data.items.length === 0) {
        notifList.innerHTML = `
            <div style="text-align:center;padding:32px 0;color:#94a3b8;">
                <svg style="width:32px;height:32px;margin:0 auto 8px;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
                <p style="font-size:0.82rem;">Tidak ada notifikasi baru</p>
            </div>`;
        return;
    }

    notifList.innerHTML = data.items.map(n => {
        const url = `${READ_BASE}/${n.id}/read`;
        const bg  = bgColors[n.tipe] || bgColors.info;
        const ico = icons[n.tipe]    || icons.info;
        return `
        <a href="${url}" style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid #f8fafc;text-decoration:none;background:#fafbff;"
            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fafbff'">
            <div style="width:34px;height:34px;border-radius:9px;background:${bg};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">${ico}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.82rem;font-weight:700;color:#0f172a;margin-bottom:2px;">${n.judul}</div>
                <div style="font-size:0.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${n.pesan}</div>
                <div style="font-size:0.7rem;color:#94a3b8;margin-top:3px;">${n.waktu}</div>
            </div>
        </a>`;
    }).join('');

}

// ===== MARK ALL READ =====
function markAllRead(e) {
    e.preventDefault();
    fetch('{{ route("guru-bk.notifications.read-all") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        seenIds.clear();
        fetchNotifications();
    });
}

// ===== POLLING 5 DETIK =====
async function fetchNotifications() {
    try {
        const res  = await fetch(NOTIF_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await res.json();
        lastData   = data;

        // Update badge
        const badge = document.getElementById('notifBadge');
        badge.style.display = data.count > 0 ? 'block' : 'none';
        badge.textContent   = data.count > 99 ? '99+' : data.count;

        // Deteksi notif BARU → tampilkan toast
        const newNotifs = data.items.filter(n => !seenIds.has(n.id));

        if (newNotifs.length > 0) {
            if (isFirstFetch) {
                newNotifs.forEach((n, index) => {
                    setTimeout(() => showToast(n), index * 1500);
                });
            } else {
                newNotifs.forEach(n => showToast(n));
            }
        }

        data.items.forEach(n => seenIds.add(n.id));
        sessionStorage.setItem('guru_seen_notif_ids', JSON.stringify([...seenIds]));
        sessionStorage.setItem('guru_notif_initialized', 'true');
        isFirstFetch = false;

        // Update dropdown kalau sedang terbuka
        if (notifDropdown.style.display === 'block') renderDropdown(data);

    } catch(e) {}
}

fetchNotifications();
setInterval(fetchNotifications, 5000);
</script>

<style>
@keyframes slideInRight {
    from { transform: translateX(120%); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}
@keyframes slideOutRight {
    from { transform: translateX(0);    opacity: 1; }
    to   { transform: translateX(120%); opacity: 0; }
}
</style>

<script>
    const sidebar     = document.getElementById('sidebar');
    const topbar      = document.getElementById('topbar');
    const mainContent = document.getElementById('mainContent');
    const toggle      = document.getElementById('sidebarToggle');
    const overlay     = document.getElementById('mobileOverlay');
    const isMobile    = () => window.innerWidth <= 768;

    // Load saved state
    if (!isMobile() && localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
        topbar.classList.add('collapsed');
        mainContent.classList.add('collapsed');
    }

    toggle.addEventListener('click', () => {
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
            topbar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });
</script>
</body>
</html>

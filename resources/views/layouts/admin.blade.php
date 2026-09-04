<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartBK') — Admin</title>
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

        * { box-sizing: border-box; margin: 0; padding: 0; }

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
            transition: width 0.3s ease;
            z-index: 100;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-w-collapsed);
        }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            min-height: var(--topbar-h);
            text-decoration: none;
        }

        .sidebar-brand__icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--maroon-mid), var(--maroon-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            font-weight: 800;
            color: var(--white);
        }

        .sidebar-brand__text {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            white-space: nowrap;
        }

        .sidebar-brand__name {
            font-size: 1rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: 0.04em;
        }

        .sidebar-brand__sub {
            font-size: 0.62rem;
            color: var(--navy-light);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-section-label {
            padding: 10px 20px 4px;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-section-label {
            opacity: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            white-space: nowrap;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: var(--white);
        }

        .nav-item.active {
            background: rgba(117, 22, 46, 0.25);
            color: var(--white);
            border-left-color: var(--maroon-mid);
        }

        .nav-item__icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item__icon svg {
            width: 18px;
            height: 18px;
        }

        .nav-item__label {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        .sidebar.collapsed .nav-item__label {
            opacity: 0;
            width: 0;
        }

        /* Tooltip saat collapsed */
        .sidebar.collapsed .nav-item:hover::after {
            content: attr(data-label);
            position: absolute;
            left: calc(var(--sidebar-w-collapsed) + 8px);
            background: var(--navy-dark);
            color: var(--white);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            white-space: nowrap;
            z-index: 999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 10px;
            background: rgba(255,255,255,0.05);
            overflow: hidden;
        }

        .sidebar-user__avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--maroon-mid), var(--maroon-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--white);
            flex-shrink: 0;
        }

        .sidebar-user__info {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .sidebar-user__info {
            opacity: 0;
            width: 0;
        }

        .sidebar-user__name {
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--white);
        }

        .sidebar-user__role {
            font-size: 0.62rem;
            color: var(--navy-light);
        }

        /* ===== TOPBAR ===== */
        .topbar {
        position: fixed;
        top: 0;
        left: var(--sidebar-w);
        right: 0;
        height: var(--topbar-h);
        background: linear-gradient(135deg, var(--navy-darkest) 0%, var(--navy-dark) 60%, var(--maroon-soft) 100%);
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        z-index: 99;
        transition: left 0.3s ease;
        box-shadow: 0 2px 8px rgba(2,16,36,0.25);
    }

        .topbar.collapsed {
            left: var(--sidebar-w-collapsed);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-toggle {
            width: 36px;
            height: 36px;
            border: none;
            background: rgba(255,255,255,0.08);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: background 0.2s;
        }

        .btn-toggle:hover {
            background: rgba(255,255,255,0.15);
        }

        .btn-toggle:hover {
            background: #e2e8f0;
        }

        .btn-toggle svg {
            width: 18px;
            height: 18px;
        }

        .topbar-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--white);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .topbar-user__avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--maroon-mid), var(--maroon-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--white);
        }

        .topbar-user__name {
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: var(--maroon-mid);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: var(--maroon-dark);
        }

        .btn-logout svg {
            width: 15px;
            height: 15px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 28px;
            min-height: calc(100vh - var(--topbar-h));
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-w-collapsed);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-w);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .topbar {
                left: 0 !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .mobile-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 99;
            }

            .mobile-overlay.active {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">

        <!-- Brand -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand__icon">S</div>
            <div class="sidebar-brand__text">
                <span class="sidebar-brand__name">SmartBK</span>
                <span class="sidebar-brand__sub">Admin Sekolah</span>
            </div>
        </a>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <div class="nav-section-label">Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               data-label="Dashboard">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
                <span class="nav-item__label">Dashboard</span>
            </a>

            <div class="nav-section-label">Data Master</div>

            <a href="{{ route('admin.tahun-ajaran.index') }}"
                class="nav-item {{ request()->routeIs('admin.tahun-ajaran.*') ? 'active' : '' }}"
                data-label="Tahun Ajaran">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Tahun Ajaran</span>
            </a>

            <a href="{{ route('admin.kelas.index') }}"
               class="nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"
               data-label="Kelas">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                <span class="nav-item__label">Kelas</span>
            </a>

            <a href="{{ route('admin.guru-bk.index') }}"
                class="nav-item {{ request()->routeIs('admin.guru-bk.*') ? 'active' : '' }}"
                data-label="Guru BK">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Guru BK</span>
            </a>

            <a href="{{ route('admin.siswa.index') }}"
                class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"
                data-label="Siswa">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Siswa</span>
            </a>

            {{-- Mutasi Siswa --}}
            <a href="{{ route('admin.mutasi-siswa.index') }}"
            class="nav-item {{ request()->routeIs('admin.mutasi-siswa.*') ? 'active' : '' }}"
            data-label="Mutasi Siswa">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </span>
                <span class="nav-item__label">Mutasi Siswa</span>
            </a>

            {{-- Jenis Pelanggaran --}}
            <a href="{{ route('admin.jenis-pelanggaran.index') }}"
            class="nav-item {{ request()->routeIs('admin.jenis-pelanggaran.*') ? 'active' : '' }}"
            data-label="Jenis Pelanggaran">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Jenis Pelanggaran</span>
            </a>

            {{-- Konfigurasi Sistem --}}
            <a href="{{ route('admin.setting.index') }}"
            class="nav-item {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}"
            data-label="Konfigurasi">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Konfigurasi</span>
            </a>

            {{-- Approval Akun --}}
            <a href="{{ route('admin.approval.index') }}"
            class="nav-item {{ request()->routeIs('admin.approval.*') ? 'active' : '' }}"
            data-label="Approval Akun">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Approval Akun</span>
            </a>

            {{-- Log Aktivitas --}}
            <a href="{{ route('admin.activity-log.index') }}"
               class="nav-item {{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}"
               data-label="Log Aktivitas">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                    </svg>
                </span>
                <span class="nav-item__label">Log Aktivitas</span>
            </a>

            {{-- Backup & Restore --}}
            <a href="{{ route('admin.backup.index') }}"
            class="nav-item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}"
            data-label="Backup & Restore">
                <span class="nav-item__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7M9 11l3 3 3-3M12 3v11"/>
                    </svg>
                </span>
                <span class="nav-item__label">Backup & Restore</span>
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
                    <div class="sidebar-user__role">Admin Sekolah</div>
                </div>
            </div>
        </div>

    </aside>

    <!-- ===== TOPBAR ===== -->
    <header class="topbar" id="topbar">
        <div class="topbar-left">
            <button class="btn-toggle" id="sidebarToggle">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
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

    <script>
        const sidebar     = document.getElementById('sidebar');
        const topbar      = document.getElementById('topbar');
        const mainContent = document.getElementById('mainContent');
        const toggle      = document.getElementById('sidebarToggle');
        const overlay     = document.getElementById('mobileOverlay');
        const isMobile    = () => window.innerWidth <= 768;

        toggle.addEventListener('click', () => {
            if (isMobile()) {
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            }
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
    </script>

    @stack('scripts')

</body>
</html>

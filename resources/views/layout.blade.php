<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Jurnal Mengajar') â€” MTsN 3 Pekanbaru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>
<body>
@php
    $isSuperAdmin = request()->routeIs('super-admin.*');
    $isAdmin = request()->routeIs('admin.*');
    $isGuru = request()->routeIs('guru.*') || request()->routeIs('input-jurnal', 'dashboard', 'laporan', 'setup');
    $roleLabel = $isSuperAdmin ? 'Super Admin' : ($isAdmin ? 'Admin Sekolah' : 'Guru Pengajar');
    $roleSub = $isSuperAdmin ? 'Verifikasi Sekolah' : ($isAdmin ? 'Monitoring Guru' : 'Pengajar');
@endphp

<nav class="topbar">
    <div class="topbar-brand">
        <div class="icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
        </div>
        <div>
            <div class="brand-name">Sistem Jurnal Mengajar</div>
            <div class="brand-sub">{{ $isSuperAdmin ? 'Pusat Verifikasi Sekolah' : ($isAdmin ? 'Panel Admin Sekolah' : 'MTsN 3 Pekanbaru') }}</div>
        </div>
    </div>
    <div class="topbar-divider"></div>
    
    <!-- Mobile menu toggle button -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle navigation menu">
        <svg viewBox="0 0 24 24">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>
    <div class="topbar-nav">
        @if($isSuperAdmin)
        <a href="{{ route('super-admin.dashboard') }}" class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('super-admin.schools.index') }}" class="nav-link {{ request()->routeIs('super-admin.schools.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/></svg>
            Sekolah
        </a>
        @elseif($isAdmin)
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Aktivitas Guru
        </a>
        <a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">Guru</a>
        <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">Kelas</a>
        <a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">Mapel</a>
        <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">Siswa</a>
        <a href="{{ route('admin.account.edit') }}" class="nav-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
            Akun
        </a>
        @else
        <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard', 'dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('guru.input-jurnal') }}" class="nav-link {{ request()->routeIs('guru.input-jurnal', 'input-jurnal') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            Input Jurnal
        </a>
        <a href="{{ route('guru.laporan') }}" class="nav-link {{ request()->routeIs('guru.laporan', 'laporan') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Laporan
        </a>
        <a href="{{ route('guru.setup') }}" class="nav-link {{ request()->routeIs('guru.setup', 'setup') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
            Setup
        </a>
        <a href="{{ route('guru.account.edit') }}" class="nav-link {{ request()->routeIs('guru.account.*') ? 'active' : '' }}">
            Akun
        </a>
        @endif
    </div>
    <div class="topbar-right">
        <div class="status-dot"><span></span>Terhubung</div>
        <div class="time-badge" id="clock">--:--:--</div>
        <div class="user-chip">
            <div class="avatar">{{ $isSuperAdmin ? 'S' : ($isAdmin ? 'A' : 'G') }}</div>
            <div>
                <div class="uname">{{ auth()->user()->name ?? $roleLabel }}</div>
                <div class="urole">{{ $roleSub }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="form-reset">
            @csrf
            <button type="submit" class="logout-link button-reset" title="Keluar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
        </form>
    </div>
</nav>

<main class="page">
    @yield('content')
</main>

<script>
    function tick() {
        const d = new Date();
        document.getElementById('clock').textContent =
            d.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
    }
    tick(); setInterval(tick, 1000);
    
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const topbarNav = document.querySelector('.topbar-nav');
        
        if (mobileMenuToggle && topbarNav) {
            mobileMenuToggle.addEventListener('click', function() {
                topbarNav.classList.toggle('mobile-active');
                
                // Toggle hamburger icon
                const svg = mobileMenuToggle.querySelector('svg');
                if (topbarNav.classList.contains('mobile-active')) {
                    // Change to X icon
                    svg.innerHTML = `
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    `;
                } else {
                    // Change back to hamburger icon
                    svg.innerHTML = `
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    `;
                }
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuToggle.contains(event.target) && !topbarNav.contains(event.target)) {
                    topbarNav.classList.remove('mobile-active');
                    const svg = mobileMenuToggle.querySelector('svg');
                    svg.innerHTML = `
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    `;
                }
            });
            
            // Close menu when window is resized to desktop size
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    topbarNav.classList.remove('mobile-active');
                    const svg = mobileMenuToggle.querySelector('svg');
                    svg.innerHTML = `
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    `;
                }
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>


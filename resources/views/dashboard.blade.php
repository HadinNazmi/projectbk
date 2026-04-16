<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistem Jurnal Mengajar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark:  #0a4a2e;
            --green-mid:   #1a7a4a;
            --green-light: #2ecc71;
            --gold:        #c9a84c;
            --gold-light:  #f0d080;
            --white:       #ffffff;
            --gray-50:     #f9f9f6;
            --gray-100:    #f0f0eb;
            --gray-200:    #e0e0d8;
            --gray-500:    #888880;
            --text-dark:   #1a1a18;
            --text-mid:    #4a4a45;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: 240px;
            background: var(--green-dark);
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: rgba(201,168,76,0.2);
            border: 1px solid rgba(201,168,76,0.4);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon svg { fill: var(--gold-light); width: 22px; height: 22px; }

        .brand-text h2 {
            font-size: 13px; font-weight: 700;
            color: var(--white); line-height: 1.3;
        }
        .brand-text p {
            font-size: 10.5px; color: rgba(255,255,255,0.5);
            margin-top: 1px;
        }

        .gold-bar { height: 2px; background: linear-gradient(90deg, var(--gold), transparent); margin: 0 20px; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }

        .nav-section-label {
            font-size: 10px; font-weight: 700;
            color: rgba(255,255,255,0.3);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 0 8px;
            margin: 16px 0 6px;
        }
        .nav-section-label:first-child { margin-top: 0; }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            color: rgba(255,255,255,0.65);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
            margin-bottom: 2px;
        }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.8; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: var(--white); }
        .nav-item.active {
            background: rgba(46,204,113,0.18);
            color: var(--white);
            border-left: 2px solid var(--gold);
        }
        .nav-item.active svg { opacity: 1; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .user-pill {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px;
            background: rgba(255,255,255,0.06);
        }
        .avatar {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, var(--green-mid), var(--gold));
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: white; flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-info .name { font-size: 13px; font-weight: 600; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-info .role { font-size: 11px; color: rgba(255,255,255,0.45); }

        /* ===== MAIN ===== */
        .main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 32px;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }

        .topbar-left h3 { font-size: 16px; font-weight: 700; }
        .topbar-left p { font-size: 12px; color: var(--gray-500); margin-top: 1px; }

        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .date-badge {
            font-size: 12px; color: var(--text-mid);
            background: var(--gray-100);
            padding: 6px 12px; border-radius: 6px;
            font-weight: 500;
        }

        .logout-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            color: #c0392b;
            background: #fff0ef;
            border: 1px solid #f5c6c2;
            cursor: pointer; text-decoration: none;
            transition: background 0.15s;
        }
        .logout-btn:hover { background: #fde0de; }
        .logout-btn svg { width: 14px; height: 14px; }

        /* Content */
        .content { padding: 32px; flex: 1; }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--gray-200);
            display: flex; align-items: flex-start; gap: 14px;
            animation: fadeUp 0.4s ease both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat-icon.green { background: rgba(26,122,74,0.1); color: var(--green-mid); }
        .stat-icon.gold  { background: rgba(201,168,76,0.12); color: var(--gold); }
        .stat-icon.blue  { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .stat-icon.purple{ background: rgba(139,92,246,0.1); color: #8b5cf6; }

        .stat-body {}
        .stat-body .label { font-size: 12px; color: var(--gray-500); font-weight: 500; }
        .stat-body .value { font-size: 26px; font-weight: 700; margin-top: 2px; letter-spacing: -0.5px; }
        .stat-body .sub   { font-size: 11.5px; color: var(--green-mid); margin-top: 2px; font-weight: 500; }

        /* Bottom grid */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
        }

        .panel {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
            animation: fadeUp 0.4s ease 0.25s both;
        }

        .panel-head {
            padding: 18px 22px;
            border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-head h4 { font-size: 14px; font-weight: 700; }
        .panel-head .badge {
            font-size: 11px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
        }
        .badge.green { background: rgba(26,122,74,0.1); color: var(--green-mid); }
        .badge.gold  { background: rgba(201,168,76,0.12); color: #9a7a30; }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 10px 22px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.7px;
            color: var(--gray-500);
            background: var(--gray-50);
            text-align: left;
        }
        tbody tr { border-top: 1px solid var(--gray-100); }
        tbody tr:hover { background: var(--gray-50); }
        tbody td {
            padding: 12px 22px;
            font-size: 13.5px;
            color: var(--text-mid);
        }
        tbody td:first-child { font-weight: 600; color: var(--text-dark); }
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
        }
        .status-pill.done { background: rgba(26,122,74,0.1); color: var(--green-mid); }
        .status-pill.pending { background: rgba(201,168,76,0.12); color: #9a7a30; }
        .status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        /* Quick links */
        .quick-links { padding: 16px; }
        .ql-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px; border-radius: 8px;
            cursor: pointer; transition: background 0.15s;
            text-decoration: none; color: inherit;
        }
        .ql-item:hover { background: var(--gray-50); }
        .ql-icon {
            width: 38px; height: 38px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .ql-icon svg { width: 18px; height: 18px; }
        .ql-icon.g { background: rgba(26,122,74,0.1); color: var(--green-mid); }
        .ql-icon.o { background: rgba(201,168,76,0.1); color: var(--gold); }
        .ql-icon.b { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .ql-icon.p { background: rgba(139,92,246,0.1); color: #8b5cf6; }
        .ql-text .t { font-size: 13.5px; font-weight: 600; }
        .ql-text .s { font-size: 12px; color: var(--gray-500); margin-top: 1px; }
        .ql-arrow { margin-left: auto; color: var(--gray-500); }
        .ql-arrow svg { width: 14px; height: 14px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
            </div>
            <div class="brand-text">
                <h2>MTsN 3 Pekanbaru</h2>
                <p>Jurnal Mengajar</p>
            </div>
        </div>
    </div>
    <div class="gold-bar"></div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a href="#" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <div class="nav-section-label">Akademik</div>

        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Jurnal Mengajar
        </a>

        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Jadwal Pelajaran
        </a>

        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Data Guru
        </a>

        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            Data Kelas
        </a>

        <div class="nav-section-label">Laporan</div>

        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Rekap Jurnal
        </a>

        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Monitoring
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-pill">
            <div class="avatar">A</div>
            <div class="user-info">
                <div class="name">Admin</div>
                <div class="role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="main">
    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <h3>Dashboard</h3>
            <p>Sistem Jurnal Mengajar MTsN 3 Pekanbaru</p>
        </div>
        <div class="topbar-right">
            <div class="date-badge" id="dateNow"></div>
            <a href="{{ route('login') }}" class="logout-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Keluar
            </a>
        </div>
    </header>

    <!-- Content -->
    <div class="content">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="stat-body">
                    <div class="label">Total Guru</div>
                    <div class="value">48</div>
                    <div class="sub">↑ Aktif mengajar</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon gold">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="stat-body">
                    <div class="label">Jurnal Hari Ini</div>
                    <div class="value">32</div>
                    <div class="sub">↑ Dari 48 sesi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div class="stat-body">
                    <div class="label">Total Kelas</div>
                    <div class="value">18</div>
                    <div class="sub">Kelas VII – IX</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="stat-body">
                    <div class="label">Kehadiran Bulan Ini</div>
                    <div class="value">94%</div>
                    <div class="sub">↑ Diatas target</div>
                </div>
            </div>
        </div>

        <!-- Bottom -->
        <div class="bottom-grid">
            <!-- Tabel jurnal -->
            <div class="panel">
                <div class="panel-head">
                    <h4>Jurnal Terbaru</h4>
                    <span class="badge green">Hari ini</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Bu Rina</td><td>Matematika</td><td>VIII-A</td><td><span class="status-pill done">Selesai</span></td></tr>
                        <tr><td>Pak Dedi</td><td>B. Indonesia</td><td>VII-C</td><td><span class="status-pill done">Selesai</span></td></tr>
                        <tr><td>Bu Sari</td><td>IPA</td><td>IX-B</td><td><span class="status-pill pending">Belum</span></td></tr>
                        <tr><td>Pak Andi</td><td>PAI</td><td>VIII-D</td><td><span class="status-pill done">Selesai</span></td></tr>
                        <tr><td>Bu Lena</td><td>B. Inggris</td><td>VII-A</td><td><span class="status-pill pending">Belum</span></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Quick links -->
            <div class="panel">
                <div class="panel-head">
                    <h4>Menu Cepat</h4>
                    <span class="badge gold">Akses</span>
                </div>
                <div class="quick-links">
                    <a href="#" class="ql-item">
                        <div class="ql-icon g"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg></div>
                        <div class="ql-text"><div class="t">Isi Jurnal Baru</div><div class="s">Tambah entri jurnal hari ini</div></div>
                        <div class="ql-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></div>
                    </a>
                    <a href="#" class="ql-item">
                        <div class="ql-icon o"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div class="ql-text"><div class="t">Lihat Jadwal</div><div class="s">Jadwal pelajaran minggu ini</div></div>
                        <div class="ql-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></div>
                    </a>
                    <a href="#" class="ql-item">
                        <div class="ql-icon b"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div class="ql-text"><div class="t">Rekap Bulanan</div><div class="s">Laporan jurnal bulan ini</div></div>
                        <div class="ql-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></div>
                    </a>
                    <a href="#" class="ql-item">
                        <div class="ql-icon p"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                        <div class="ql-text"><div class="t">Data Guru</div><div class="s">Kelola data pengajar</div></div>
                        <div class="ql-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const d = new Date();
    const opt = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    document.getElementById('dateNow').textContent = d.toLocaleDateString('id-ID', opt);
</script>
</body>
</html>
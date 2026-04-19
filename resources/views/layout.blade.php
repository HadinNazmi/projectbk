<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Jurnal Mengajar') — MTsN 3 Pekanbaru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark:   #083d26;
            --green-mid:    #156b42;
            --green-light:  #22a85d;
            --green-pale:   #e6f7ef;
            --gold:         #c9a84c;
            --gold-light:   #f0d080;
            --white:        #ffffff;
            --bg:           #f2f4f3;
            --gray-100:     #eceeed;
            --gray-200:     #d8dad9;
            --gray-400:     #9a9c9b;
            --gray-600:     #5a5c5b;
            --text:         #181c1a;
            --text-mid:     #3d4240;
            --radius:       10px;
            --shadow:       0 2px 12px rgba(0,0,0,0.07);
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-size: 14px;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
            height: 56px;
            display: flex; align-items: center;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 200;
            box-shadow: 0 2px 16px rgba(0,0,0,0.18);
        }
        .topbar-brand {
            display: flex; align-items: center; gap: 10px;
            margin-right: 32px;
        }
        .topbar-brand .icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(201,168,76,0.25);
            border: 1px solid rgba(201,168,76,0.5);
            display: flex; align-items: center; justify-content: center;
        }
        .topbar-brand .icon svg { width: 18px; height: 18px; fill: var(--gold-light); }
        .topbar-brand .brand-name { font-size: 14px; font-weight: 700; color: #fff; line-height: 1.2; }
        .topbar-brand .brand-sub  { font-size: 10.5px; color: rgba(255,255,255,0.55); }

        .topbar-divider { width: 1px; height: 28px; background: rgba(255,255,255,0.15); margin-right: 20px; }

        /* NAV */
        .topbar-nav { display: flex; gap: 4px; flex: 1; }
        .nav-link {
            display: flex; align-items: center; gap: 7px;
            padding: 7px 14px; border-radius: 7px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }
        .nav-link svg { width: 14px; height: 14px; flex-shrink: 0; }
        .nav-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-link.active { background: rgba(255,255,255,0.15); color: #fff; font-weight: 600; }
        .nav-link.active::after {
            content: '';
            display: block;
            position: absolute;
            bottom: -1px; left: 14px; right: 14px;
            height: 2px;
            background: var(--gold);
            border-radius: 2px 2px 0 0;
        }
        .nav-link { position: relative; }

        .topbar-right { display: flex; align-items: center; gap: 12px; margin-left: auto; }

        .status-dot {
            display: flex; align-items: center; gap: 6px;
            font-size: 11.5px; color: rgba(255,255,255,0.7);
        }
        .status-dot span {
            width: 7px; height: 7px; border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 0 2px rgba(74,222,128,0.3);
            animation: pulse 2s ease infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.6} }

        .time-badge {
            font-size: 12px; color: rgba(255,255,255,0.6);
            font-variant-numeric: tabular-nums;
        }

        .user-chip {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 10px 5px 6px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            cursor: pointer;
        }
        .avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--green-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: white;
        }
        .user-chip .uname { font-size: 12px; font-weight: 600; color: #fff; }
        .user-chip .urole { font-size: 10.5px; color: rgba(255,255,255,0.55); }

        .logout-link {
            display: flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 7px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .logout-link:hover { background: rgba(220,38,38,0.2); color: #f87171; }
        .logout-link svg { width: 15px; height: 15px; }

        /* ===== PAGE WRAPPER ===== */
        .page { max-width: 960px; margin: 0 auto; padding: 28px 20px 60px; }

        /* ===== HERO BANNER ===== */
        .hero {
            border-radius: 14px;
            padding: 22px 28px;
            margin-bottom: 24px;
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: space-between;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: repeating-linear-gradient(
                45deg,
                transparent, transparent 20px,
                rgba(255,255,255,0.04) 20px, rgba(255,255,255,0.04) 21px
            );
        }
        .hero-left { position: relative; z-index: 1; }
        .hero-left .hero-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
        }
        .hero-left .hero-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .hero-left h1 { font-size: 20px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }
        .hero-left p  { font-size: 13px; color: rgba(255,255,255,0.75); margin-top: 3px; }
        .hero-badge {
            position: relative; z-index: 1;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 8px;
            padding: 10px 16px;
            text-align: center;
        }
        .hero-badge .hb-label { font-size: 10.5px; color: rgba(255,255,255,0.65); }
        .hero-badge .hb-val   { font-size: 13px; font-weight: 700; color: #fff; margin-top: 2px; }

        /* ===== CARD ===== */
        .card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-head {
            padding: 16px 22px;
            border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; gap: 10px;
        }
        .card-head .step-num {
            width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .card-head h3 { font-size: 14px; font-weight: 700; }
        .card-body { padding: 22px; }

        /* ===== FORM ELEMENTS ===== */
        .form-row { display: grid; gap: 16px; margin-bottom: 16px; }
        .form-row.cols-2 { grid-template-columns: 1fr 1fr; }
        .form-row.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
        .form-row.cols-12 { grid-template-columns: 1fr 2fr; }

        .form-group label {
            display: flex; align-items: center; gap: 5px;
            font-size: 12px; font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 6px;
            letter-spacing: 0.1px;
        }
        .form-group label svg { width: 12px; height: 12px; }

        .form-control {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 13.5px;
            color: var(--text);
            background: #fafafa;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--green-mid);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(21,107,66,0.09);
        }
        textarea.form-control { resize: vertical; min-height: 90px; }
        select.form-control { cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239a9c9b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* JAM PICKER */
        .jam-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
        .jam-btn {
            border: 1.5px solid var(--gray-200);
            background: #fafafa;
            border-radius: 10px;
            padding: 12px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
        }
        .jam-btn .num {
            width: 28px; height: 28px;
            border: 1.5px solid var(--gray-200);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            color: var(--gray-600);
            margin: 0 auto 6px;
            transition: all 0.15s;
        }
        .jam-btn .lbl { font-size: 11.5px; color: var(--gray-600); font-weight: 500; }
        .jam-btn:hover { border-color: var(--green-mid); background: var(--green-pale); }
        .jam-btn:hover .num { border-color: var(--green-mid); color: var(--green-mid); }
        .jam-btn.selected {
            border-color: var(--green-mid);
            background: var(--green-pale);
        }
        .jam-btn.selected .num {
            background: var(--green-mid);
            border-color: var(--green-mid);
            color: #fff;
        }
        .jam-btn.selected .lbl { color: var(--green-mid); font-weight: 600; }

        /* FOTO UPLOAD */
        .foto-drop {
            border: 2px dashed var(--gray-200);
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            position: relative;
        }
        .foto-drop:hover, .foto-drop.dragover {
            border-color: var(--green-mid);
            background: var(--green-pale);
        }
        .foto-drop input[type=file] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer;
        }
        .foto-drop .drop-icon {
            width: 44px; height: 44px; border-radius: 10px;
            background: var(--gray-100);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
        }
        .foto-drop .drop-icon svg { width: 22px; height: 22px; stroke: var(--gray-400); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .foto-drop .drop-text { font-size: 13.5px; font-weight: 600; color: var(--text-mid); }
        .foto-drop .drop-sub  { font-size: 12px; color: var(--gray-400); margin-top: 3px; }
        .foto-preview { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px; }
        .foto-thumb {
            width: 80px; height: 80px; border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--gray-200);
        }

        /* ABSEN GRID */
        .absen-header { display: grid; grid-template-columns: 40px 1fr repeat(4, 80px); gap: 0; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-400); padding: 10px 16px; background: #f7f8f7; border-bottom: 1px solid var(--gray-100); }
        .absen-row    { display: grid; grid-template-columns: 40px 1fr repeat(4, 80px); gap: 0; padding: 11px 16px; border-bottom: 1px solid var(--gray-100); align-items: center; transition: background 0.12s; }
        .absen-row:hover { background: #f9faf9; }
        .absen-row .no { font-size: 12px; color: var(--gray-400); }
        .absen-row .nama { font-size: 13.5px; font-weight: 500; }
        .absen-status { display: flex; justify-content: center; }
        .absen-status input[type=radio] { display: none; }
        .absen-status label {
            width: 32px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px;
            font-size: 12px; font-weight: 700;
            cursor: pointer;
            border: 1.5px solid var(--gray-200);
            color: var(--gray-400);
            transition: all 0.12s;
        }
        .absen-status input[value=H]:checked ~ label.H { background: #dcfce7; border-color: #16a34a; color: #15803d; }
        .absen-status input[value=S]:checked ~ label.S { background: #fef9c3; border-color: #ca8a04; color: #92400e; }
        .absen-status input[value=I]:checked ~ label.I { background: #dbeafe; border-color: #2563eb; color: #1d4ed8; }
        .absen-status input[value=A]:checked ~ label.A { background: #fee2e2; border-color: #dc2626; color: #b91c1c; }
        .absen-status label:hover { border-color: var(--green-mid); color: var(--green-mid); }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px; border-radius: var(--radius); font-family: inherit; font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; transition: all 0.15s; text-decoration: none; }
        .btn svg { width: 15px; height: 15px; }
        .btn-primary { background: linear-gradient(135deg, var(--green-dark), var(--green-mid)); color: #fff; }
        .btn-primary:hover { opacity: 0.88; }
        .btn-outline { background: #fff; color: var(--text-mid); border: 1.5px solid var(--gray-200); }
        .btn-outline:hover { border-color: var(--green-mid); color: var(--green-mid); }
        .btn-full { width: 100%; justify-content: center; padding: 13px; font-size: 14.5px; }

        .btn-row { display: flex; gap: 12px; margin-top: 4px; }
        .btn-row .btn-primary { flex: 1; }

        /* STATS ROW */
        .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 22px; }
        .stat-card { background: var(--white); border-radius: 12px; border: 1px solid var(--gray-200); padding: 18px 20px; display: flex; align-items: flex-start; gap: 14px; box-shadow: var(--shadow); animation: fadeUp 0.4s ease both; }
        .stat-card:nth-child(1){animation-delay:.05s} .stat-card:nth-child(2){animation-delay:.1s} .stat-card:nth-child(3){animation-delay:.15s} .stat-card:nth-child(4){animation-delay:.2s}
        @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat-icon.red    { background: #fee2e2; color: #dc2626; }
        .stat-icon.green  { background: var(--green-pale); color: var(--green-mid); }
        .stat-icon.purple { background: #ede9fe; color: #7c3aed; }
        .stat-icon.amber  { background: #fef3c7; color: #d97706; }
        .stat-val   { font-size: 26px; font-weight: 700; letter-spacing: -0.5px; }
        .stat-label { font-size: 12px; color: var(--gray-400); font-weight: 500; }
        .stat-sub   { font-size: 11.5px; color: var(--green-mid); font-weight: 500; margin-top: 2px; }

        /* MATRIX */
        .matrix-wrap { overflow-x: auto; }
        .matrix { border-collapse: collapse; width: 100%; min-width: 700px; }
        .matrix th { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-400); padding: 10px 12px; background: #f7f8f7; text-align: center; border-bottom: 1px solid var(--gray-100); white-space: nowrap; }
        .matrix th:first-child { text-align: left; }
        .matrix td { padding: 8px 6px; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        .matrix td:first-child { padding-left: 16px; font-size: 13px; font-weight: 600; white-space: nowrap; }
        .matrix-kls { display: flex; align-items: center; gap: 6px; }
        .kls-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green-mid); flex-shrink: 0; }
        .matrix-cell { text-align: center; }
        .cell-pill {
            display: inline-flex; flex-direction: column; align-items: center;
            padding: 5px 6px; border-radius: 7px; font-size: 10px; font-weight: 600;
            line-height: 1.3; min-width: 54px; cursor: default;
        }
        .cell-pill.empty  { background: #fee2e2; color: #b91c1c; }
        .cell-pill.filled { background: var(--green-pale); color: var(--green-mid); }
        .cell-pill .cn { font-size: 10.5px; }
        .cell-pill .cs { font-size: 9.5px; opacity: 0.8; }

        /* LAPORAN TABS */
        .tab-row { display: flex; gap: 8px; margin-bottom: 22px; flex-wrap: wrap; }
        .tab-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: var(--radius);
            font-size: 13px; font-weight: 600;
            cursor: pointer; border: 1.5px solid var(--gray-200);
            background: #fff; color: var(--gray-600);
            transition: all 0.15s;
        }
        .tab-btn svg { width: 14px; height: 14px; }
        .tab-btn.active { background: var(--green-mid); color: #fff; border-color: var(--green-mid); }
        .tab-btn:hover:not(.active) { border-color: var(--green-mid); color: var(--green-mid); }

        /* TABLE */
        .tbl { width: 100%; border-collapse: collapse; }
        .tbl thead th { padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-400); background: #f7f8f7; text-align: left; border-bottom: 1px solid var(--gray-100); white-space: nowrap; }
        .tbl tbody tr { border-top: 1px solid var(--gray-100); transition: background 0.1s; }
        .tbl tbody tr:hover { background: #f9faf9; }
        .tbl tbody td { padding: 11px 16px; font-size: 13.5px; color: var(--text-mid); }
        .tbl tbody td:first-child { font-weight: 600; color: var(--text); }

        .pill { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .pill.done    { background: var(--green-pale); color: var(--green-mid); }
        .pill.pending { background: #fef3c7; color: #b45309; }
        .pill.live    { background: #ede9fe; color: #6d28d9; }

        .tbl-empty { padding: 40px; text-align: center; color: var(--gray-400); font-size: 13.5px; }
        .tbl-empty svg { width: 36px; height: 36px; stroke: var(--gray-200); fill: none; stroke-width: 1.5; display: block; margin: 0 auto 10px; }

        /* FILTER ROW */
        .filter-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 12px; align-items: end; margin-bottom: 8px; }
        .filter-row .btn { height: 40px; }

        .export-row { display: flex; gap: 8px; margin-top: 10px; }

        /* EMPTY STATE */
        .empty-state { padding: 48px; text-align: center; }
        .empty-state svg { width: 44px; height: 44px; stroke: var(--gray-200); fill: none; stroke-width: 1.5; display: block; margin: 0 auto 12px; }
        .empty-state h4 { font-size: 15px; font-weight: 600; color: var(--gray-600); }
        .empty-state p  { font-size: 13px; color: var(--gray-400); margin-top: 4px; }

        /* SECTION DIVIDER */
        .section-divider { display: flex; align-items: center; gap: 12px; margin: 24px 0 16px; }
        .section-divider .sd-line { flex: 1; height: 1px; background: var(--gray-100); }
        .section-divider .sd-text { font-size: 11px; font-weight: 700; color: var(--gray-400); text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; }

        /* LEGEND */
        .legend { display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--gray-600); }
        .legend-dot { width: 10px; height: 10px; border-radius: 2px; }

        @keyframes fadeIn { from{opacity:0} to{opacity:1} }
        .page { animation: fadeIn 0.3s ease; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="topbar">
    <div class="topbar-brand">
        <div class="icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
        </div>
        <div>
            <div class="brand-name">Sistem Jurnal Mengajar</div>
            <div class="brand-sub">MTsN 3 Pekanbaru</div>
        </div>
    </div>
    <div class="topbar-divider"></div>
    <div class="topbar-nav">
        <a href="{{ route('input-jurnal') }}" class="nav-link {{ request()->routeIs('input-jurnal') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            Input Jurnal
        </a>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('laporan') }}" class="nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Laporan
        </a>
        <a href="{{ route('setup') }}" class="nav-link {{ request()->routeIs('setup') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
            Setup
        </a>
    </div>
    <div class="topbar-right">
        <div class="status-dot"><span></span>Terhubung</div>
        <div class="time-badge" id="clock">--:--:--</div>
        <div class="user-chip">
            <div class="avatar">G</div>
            <div>
                <div class="uname">Guru Pengajar</div>
                <div class="urole">Pengajar</div>
            </div>
        </div>
        <a href="{{ route('login') }}" class="logout-link" title="Keluar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </a>
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
</script>
@stack('scripts')
</body>
</html>
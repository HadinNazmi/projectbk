@extends('layout')
@section('title', 'Dashboard Admin')

@section('content')
@php
    $activities = [
        ['teacher' => 'Bu Rina Handayani', 'subject' => 'Matematika', 'class' => 'VIII.1', 'time' => '07:30', 'status' => 'Selesai', 'journal' => 'Materi persamaan linear dan latihan kelompok'],
        ['teacher' => 'Pak Dedi Kurniawan', 'subject' => 'Bahasa Indonesia', 'class' => 'VII.2', 'time' => '08:15', 'status' => 'Berlangsung', 'journal' => 'Membaca teks eksplanasi'],
        ['teacher' => 'Bu Sari Wulandari', 'subject' => 'IPA', 'class' => 'IX.1', 'time' => '09:45', 'status' => 'Belum Input', 'journal' => '-'],
        ['teacher' => 'Pak Andi Saputra', 'subject' => 'IPS', 'class' => 'VIII.3', 'time' => '10:30', 'status' => 'Selesai', 'journal' => 'Perdagangan antar daerah'],
        ['teacher' => 'Bu Lena Marliana', 'subject' => 'Bahasa Inggris', 'class' => 'VII.1', 'time' => '11:15', 'status' => 'Terlambat', 'journal' => 'Menunggu konfirmasi jurnal'],
    ];
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

<section class="admin-monitor-hero">
    <div>
        <h1>Dashboard Admin Sekolah</h1>
        <p>Pantau aktivitas guru, status jurnal mengajar, kelas berjalan, dan guru yang belum melakukan input jurnal pada hari ini.</p>
    </div>
    <div class="monitor-chip">
        <span class="live-dot"></span>
        Monitoring Hari Ini
    </div>
</section>

@if(! auth()->user()->password_changed_at)
<div class="card card-warning">
    <div class="warning-row">
        <div>
            <div class="warning-title">Password masih password awal</div>
            <div class="warning-text">Silakan ganti password agar akun admin lebih aman dan mudah digunakan.</div>
        </div>
        <a href="{{ route('admin.account.edit') }}" class="btn btn-primary">Ganti Password</a>
    </div>
</div>
@endif

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div><div class="stat-label">Guru Aktif</div><div class="stat-val">58</div><div class="stat-sub">Dari 62 guru</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
        </div>
        <div><div class="stat-label">Jurnal Terisi</div><div class="stat-val">84%</div><div class="stat-sub">136 dari 162 jam</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div><div class="stat-label">Kelas Berjalan</div><div class="stat-val">18</div><div class="stat-sub">Semua rombel aktif</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
        </div>
        <div><div class="stat-label">Perlu Follow Up</div><div class="stat-val">7</div><div class="stat-sub">Belum input jurnal</div></div>
    </div>
</div>

<div class="monitor-grid">
    <div class="card">
        <div class="card-head card-head-between">
            <h3>Aktivitas Guru Terbaru</h3>
            <span class="pill live">Live</span>
        </div>
        <div class="card-body">
            @foreach($activities as $activity)
                @php
                    $tag = $activity['status'] === 'Selesai' ? 'ok' : ($activity['status'] === 'Berlangsung' ? 'run' : ($activity['status'] === 'Terlambat' ? 'late' : 'miss'));
                @endphp
                <div class="teacher-card">
                    <div class="teacher-avatar">{{ substr($activity['teacher'], 0, 1) }}</div>
                    <div>
                        <h4>{{ $activity['teacher'] }}</h4>
                        <p>{{ $activity['time'] }} - {{ $activity['subject'] }} - {{ $activity['class'] }} | {{ $activity['journal'] }}</p>
                    </div>
                    <span class="status-tag {{ $tag }}">{{ $activity['status'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h3>Beban Aktivitas Kelas</h3></div>
        <div class="card-body">
            <div class="class-load">
                @foreach(['VII.1' => 88, 'VII.2' => 72, 'VIII.1' => 96, 'VIII.3' => 64, 'IX.1' => 81] as $class => $value)
                <div class="load-row">
                    <strong>{{ $class }}</strong>
                    <div class="bar"><span class="bar-width-{{ $value }}"></span></div>
                    <span>{{ $value }}%</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head"><h3>Daftar Guru Belum Input Jurnal</h3></div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Guru</th>
                <th>Jam</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Bu Sari Wulandari</td><td>09:45</td><td>IX.1</td><td>IPA</td><td><span class="status-tag miss">Belum Input</span></td><td>Menunggu jurnal jam ke-4</td></tr>
            <tr><td>Bu Lena Marliana</td><td>11:15</td><td>VII.1</td><td>Bahasa Inggris</td><td><span class="status-tag late">Terlambat</span></td><td>Perlu konfirmasi admin</td></tr>
            <tr><td>Pak Fikri Ananda</td><td>12:30</td><td>VIII.2</td><td>PKn</td><td><span class="status-tag miss">Belum Input</span></td><td>Belum ada aktivitas</td></tr>
        </tbody>
    </table>
</div>
@endsection


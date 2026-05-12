@extends('layout')
@section('title', 'Setup')

@section('content')
<div class="hero hero-spaced">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        </div>
        <h1>Setup & Konfigurasi</h1>
        <p>Shortcut fitur yang bisa diakses oleh guru.</p>
    </div>
    <div class="hero-badge">
        <div class="hb-label">Akses</div>
        <div class="hb-val">Guru</div>
    </div>
</div>

<div class="setup-grid">
    @php
    $menus = [
        ['icon'=>'I','title'=>'Input Jurnal','sub'=>'Isi jurnal mengajar harian','color'=>'#22a85d','route'=>route('guru.input-jurnal')],
        ['icon'=>'D','title'=>'Dashboard Guru','sub'=>'Pantau ringkasan kelas dan jurnal','color'=>'#7c3aed','route'=>route('guru.dashboard')],
        ['icon'=>'J','title'=>'Jurnal','sub'=>'Kelola data jurnal yang tersimpan','color'=>'#0d9488','route'=>route('guru.journals.index')],
        ['icon'=>'L','title'=>'Laporan','sub'=>'Lihat rekap dan analisis jurnal','color'=>'#2563eb','route'=>route('guru.laporan')],
    ];
    @endphp
    @foreach($menus as $m)
    <a href="{{ $m['route'] }}" class="card setup-card">
        <div class="card-body setup-card-body">
            <div class="setup-icon">{{ $m['icon'] }}</div>
            <div>
                <div class="setup-title">{{ $m['title'] }}</div>
                <div class="muted-note">{{ $m['sub'] }}</div>
            </div>
            <div class="setup-arrow">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endsection

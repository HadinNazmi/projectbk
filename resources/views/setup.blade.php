@extends('layout')
@section('title', 'Setup')

@section('content')

<div class="hero" style="background:linear-gradient(135deg,#1e3a5f 0%,#2563eb 100%);margin-bottom:22px;">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        </div>
        <h1>Setup & Konfigurasi</h1>
        <p>Kelola data master, pengguna, dan pengaturan sistem</p>
    </div>
    <div class="hero-badge">
        <div class="hb-label">Akses</div>
        <div class="hb-val">Admin Only</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
    @php
    $menus = [
        ['icon'=>'👤','title'=>'Data Guru','sub'=>'Kelola data & akun guru','color'=>'#22a85d'],
        ['icon'=>'🏫','title'=>'Data Kelas','sub'=>'Kelola kelas & rombongan belajar','color'=>'#7c3aed'],
        ['icon'=>'📚','title'=>'Mata Pelajaran','sub'=>'Kelola daftar mata pelajaran','color'=>'#d97706'],
        ['icon'=>'👥','title'=>'Data Siswa','sub'=>'Kelola data siswa per kelas','color'=>'#2563eb'],
        ['icon'=>'📅','title'=>'Jadwal','sub'=>'Atur jadwal pelajaran','color'=>'#0d9488'],
        ['icon'=>'🔐','title'=>'Manajemen User','sub'=>'Kelola role & hak akses','color'=>'#dc2626'],
    ];
    @endphp
    @foreach($menus as $m)
    <div class="card" style="margin:0;cursor:pointer;transition:box-shadow 0.15s,transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div class="card-body" style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:{{ $m['color'] }}18;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">{{ $m['icon'] }}</div>
            <div>
                <div style="font-size:14px;font-weight:700;">{{ $m['title'] }}</div>
                <div style="font-size:12px;color:var(--gray-400);margin-top:2px;">{{ $m['sub'] }}</div>
            </div>
            <div style="margin-left:auto;color:var(--gray-200);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
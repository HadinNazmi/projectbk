@extends('layout')
@section('title', 'Dashboard')

@section('content')

{{-- STATS ROW --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="stat-label">Kehadiran Guru Hari Ini</div>
            <div class="stat-val">0%</div>
            <div class="stat-sub">Belum ada jurnal</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
        <div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-val">973</div>
            <div class="stat-sub">18 Kelas aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-label">Total Guru</div>
            <div class="stat-val">62</div>
            <div class="stat-sub">Aktif mengajar</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div>
            <div class="stat-label">Kehadiran Siswa Hari Ini</div>
            <div class="stat-val">0%</div>
            <div class="stat-sub">Menunggu jurnal</div>
        </div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div class="chart-grid">

    {{-- Persentase Kehadiran Guru --}}
    <div class="card mb-none">
        <div class="card-head card-head-between">
            <div>
                <h3 class="back-link">● Persentase Kehadiran Guru</h3>
                <div class="tiny-muted">Tren 7 hari terakhir</div>
            </div>
            <div class="tiny-muted">Jam fiktif (contoh data)</div>
        </div>
        <div class="card-body" class="chart-body">
            <canvas id="chartGuru" height="140"></canvas>
            <div class="legend legend-spaced">
                <div class="legend-item"><div class="legend-dot" class="legend-good"></div> Persentase Kehadiran</div>
            </div>
        </div>
    </div>

    {{-- Kehadiran Siswa Per Kelas --}}
    <div class="card mb-none">
        <div class="card-head card-head-between">
            <div>
                <h3 class="danger-title">● Kehadiran Siswa Per Kelas</h3>
                <div class="tiny-muted">Data hari ini</div>
            </div>
            <div class="tiny-muted">Scroll →</div>
        </div>
        <div class="card-body" class="chart-scroll">
            <canvas id="chartSiswa" height="140" class="chart-min"></canvas>
            <div class="legend legend-wrap">
                <div class="legend-item"><div class="legend-dot" class="legend-good"></div> Baik (≥85%)</div>
                <div class="legend-item"><div class="legend-dot" class="legend-mid"></div> Sedang (70–79%)</div>
                <div class="legend-item"><div class="legend-dot" class="legend-bad"></div> Rendah (&lt;70%)</div>
            </div>
        </div>
    </div>
</div>

{{-- REKAPITULASI KEHADIRAN --}}
<div class="card">
    <div class="card-head rekap-head">
        <div>
            <h3 class="text-white">📊 Rekapitulasi Kehadiran Siswa Hari Ini</h3>
            <div class="white-muted">Data real-time dengan deduplikasi · 1 siswa per nama · Hadir per kelas</div>
        </div>
        <span class="pill live live-pill-inverse">Live Data</span>
    </div>
    <div class="empty-state">
        <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        <h4>Belum ada data kehadiran hari ini</h4>
        <p>Data akan muncul setelah guru mengisi jurnal</p>
    </div>
</div>

{{-- MATRIX KEHADIRAN GURU REAL-TIME --}}
<div class="card">
    <div class="card-head card-head-wrap">
        <div>
            <h3>🗓 Matrix Kehadiran Guru Real-Time</h3>
            <div class="muted-note">Status kehadiran guru per jam per kelas</div>
        </div>
        <div class="legend-row">
            <span class="legend-chip"><span class="legend-box legend-h"></span>Ada Guru</span>
            <span class="legend-chip"><span class="legend-box legend-a"></span>Kelas Kosong</span>
            <span class="hover-note">Hover untuk detail →</span>
        </div>
    </div>
    <div class="matrix-wrap matrix-padded">
        <table class="matrix">
            <thead>
                <tr>
                    <th class="minw-class">Kelas</th>
                    @for($j=1;$j<=10;$j++)<th>Jam {{ $j }}</th>@endfor
                </tr>
            </thead>
            <tbody>
                @php
                $kelas = ['VII.1','VII.2','VII.3','VII.4','VIII.1','VIII.2','VIII.3','VIII.4','IX.1','IX.2'];
                @endphp
                @foreach($kelas as $k)
                <tr>
                    <td>
                        <div class="matrix-kls">
                            <div class="kls-dot"></div>
                            {{ $k }}
                        </div>
                    </td>
                    @for($j=1;$j<=10;$j++)
                    <td class="matrix-cell">
                        <div class="cell-pill empty" title="Kelas Kosong">
                            <span class="cn">Kosong</span>
                            <span class="cs">Jam {{ $j }}</span>
                        </div>
                    </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
const styleFont = "'Plus Jakarta Sans', sans-serif";
const gridColor = 'rgba(0,0,0,0.05)';

// Chart Kehadiran Guru
new Chart(document.getElementById('chartGuru'), {
    type: 'line',
    data: {
        labels: ['14/04','15/04','16/04','17/04','18/04','19/04','20/04'],
        datasets: [{
            label: 'Persentase Kehadiran',
            data: [74, 91, 88, 86, 83, 83, 83],
            borderColor: '#22a85d',
            backgroundColor: 'rgba(34,168,93,0.08)',
            tension: 0.4, fill: true, pointRadius: 4,
            pointBackgroundColor: '#22a85d',
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { min: 0, max: 100, grid: { color: gridColor }, ticks: { font: { family: styleFont, size: 11 }, callback: v => v+'%' } },
            x: { grid: { display: false }, ticks: { font: { family: styleFont, size: 11 } } }
        }
    }
});

// Chart Siswa Per Kelas
const kelasLabels = ['VII.1','VII.2','VII.3','VII.4','VIII.1','VIII.2','VIII.3','VIII.4','IX.1','IX.2'];
const nilaiSiswa  = [0,0,0,0,0,0,0,0,0,0];
new Chart(document.getElementById('chartSiswa'), {
    type: 'bar',
    data: {
        labels: kelasLabels,
        datasets: [{
            label: 'Kehadiran (%)',
            data: nilaiSiswa,
            backgroundColor: nilaiSiswa.map(v => v >= 85 ? '#22a85d' : v >= 70 ? '#f59e0b' : '#ef4444'),
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { min: 0, max: 100, grid: { color: gridColor }, ticks: { font: { family: styleFont, size: 11 }, callback: v => v+'%' } },
            x: { grid: { display: false }, ticks: { font: { family: styleFont, size: 11 } } }
        }
    }
});
</script>
@endpush


@extends('layout')
@section('title', 'Laporan & Analisis')

@section('content')

{{-- HERO --}}
<div class="hero laporan-hero">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        </div>
        <h1>Laporan & Analisis</h1>
        <p>Lihat rekap jurnal dan analisis kehadiran siswa secara detail</p>
    </div>
    <div class="hero-badge">
        <div class="hb-label">Data Tersedia</div>
        <div class="hb-val hb-ready">● Real-time</div>
    </div>
</div>

{{-- TABS --}}
<div class="tab-row">
    <button class="tab-btn active" onclick="switchTab(this,'rekap')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Rekap Jurnal
    </button>
    <button class="tab-btn" onclick="switchTab(this,'perkelas')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        Rekap Per Kelas
    </button>
    <button class="tab-btn" onclick="switchTab(this,'individu')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Rekap Individu
    </button>
    <button class="tab-btn" onclick="switchTab(this,'analisis')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Analisis Data
    </button>
</div>

{{-- TAB: Rekap Jurnal --}}
<div id="tab-rekap">
    {{-- Filter --}}
    <div class="card">
        <div class="card-head">
            <div class="step-num step-green">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            </div>
            <h3>Filter Data Jurnal</h3>
        </div>
        <div class="card-body">
            <form class="filter-row" action="{{ route('guru.laporan') }}" method="GET">
                <div class="form-group" class="field-reset">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Guru Pengajar
                    </label>
                    <select class="form-control" name="teacher_id">
                        <option value="">Semua Guru</option>
                        @foreach(($teachers ?? collect()) as $teacher)
                        <option value="{{ $teacher->id }}" @selected(request('teacher_id') == $teacher->id)>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" class="field-reset">
                    <label>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Tanggal
                    </label>
                    <input type="date" name="date" class="form-control" value="{{ request('date', date('Y-m-d')) }}">
                </div>
                <button class="btn btn-primary" type="submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    Terapkan Filter
                </button>
            </form>
            <div class="export-row">
                <a href="{{ route('guru.journals.export') }}" class="btn btn-outline btn-export">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Excel
                </a>
                <button type="button" onclick="window.print()" class="btn btn-outline btn-export">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Print
                </button>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card">
        <div class="card-head card-head-between">
            <h3>Data Jurnal Mengajar</h3>
            <div class="legend-row tiny-muted">
                <span class="legend-chip"><span class="legend-dot-small legend-good"></span> S = Sakit</span>
                <span class="legend-chip"><span class="legend-dot-small legend-blue"></span> I = Izin</span>
                <span class="legend-chip"><span class="legend-dot-small legend-bad"></span> A = Alfa</span>
            </div>
        </div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Guru</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Materi</th>
                    <th>Metode</th>
                    <th class="center-text">S</th>
                    <th class="center-text">I</th>
                    <th class="center-text">A</th>
                    <th class="center-text">%</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($journals ?? collect()) as $journal)
                @php
                    $total = max($journal->present_count + $journal->sick_count + $journal->permission_count + $journal->absent_count, 1);
                    $percentage = round(($journal->present_count / $total) * 100);
                @endphp
                <tr>
                    <td>{{ $journal->teacher?->name ?? '-' }}</td>
                    <td>{{ optional($journal->date)->format('d/m/Y') }}</td>
                    <td>{{ $journal->lesson_hour }}</td>
                    <td>{{ $journal->schoolClass?->name ?? '-' }}</td>
                    <td>{{ $journal->subject?->name ?? '-' }}</td>
                    <td>{{ $journal->material ?? '-' }}</td>
                    <td>{{ $journal->method ?? '-' }}</td>
                    <td class="center-text">{{ $journal->sick_count }}</td>
                    <td class="center-text">{{ $journal->permission_count }}</td>
                    <td class="center-text">{{ $journal->absent_count }}</td>
                    <td class="center-text">{{ $percentage }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11">
                        <div class="tbl-empty">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Tidak ada data sesuai filter
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TAB: Per Kelas --}}
<div id="tab-perkelas" class="hidden">
    <div class="card">
        <div class="card-head"><h3>Rekap Kehadiran Per Kelas</h3></div>
        <div class="empty-state">
            <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            <h4>Belum ada data</h4>
            <p>Isi jurnal terlebih dahulu untuk melihat rekap per kelas</p>
        </div>
    </div>
</div>

{{-- TAB: Individu --}}
<div id="tab-individu" class="hidden">
    <div class="card">
        <div class="card-head">
            <h3>Rekap Individu Siswa</h3>
        </div>
        <div class="card-body">
            <div class="form-row cols-2 mb-none">
                <div class="form-group" class="field-reset">
                    <label>Pilih Kelas</label>
                    <select class="form-control">
                        <option>Pilih Kelas...</option>
                        <option>VII.1</option><option>VII.2</option><option>VIII.1</option>
                    </select>
                </div>
                <div class="form-group" class="field-reset">
                    <label>Rentang Tanggal</label>
                    <input type="date" class="form-control">
                </div>
            </div>
        </div>
        <div class="empty-state">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <h4>Pilih kelas untuk melihat rekap individu</h4>
            <p>Data akan muncul setelah memilih kelas dan periode</p>
        </div>
    </div>
</div>

{{-- TAB: Analisis --}}
<div id="tab-analisis" class="hidden">
    <div class="analysis-grid">
        <div class="card mb-none">
            <div class="card-head"><h3>Tren Kehadiran Bulanan</h3></div>
            <div class="card-body"><canvas id="chartTren" height="180"></canvas></div>
        </div>
        <div class="card mb-none">
            <div class="card-head"><h3>Distribusi Metode Pembelajaran</h3></div>
            <div class="card-body"><canvas id="chartMetode" height="180"></canvas></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
function switchTab(el, id) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    ['rekap','perkelas','individu','analisis'].forEach(t => {
        document.getElementById('tab-'+t).style.display = t===id ? '' : 'none';
    });
    if (id === 'analisis') initChartAnalisis();
}

let chartAnalisisDone = false;
function initChartAnalisis() {
    if (chartAnalisisDone) return;
    chartAnalisisDone = true;
    const font = { family: "'Plus Jakarta Sans', sans-serif", size: 11 };
    new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
            datasets: [{
                label: 'Kehadiran Siswa (%)',
                data: [88, 91, 85, 87, 90, 0],
                borderColor: '#0d9488', backgroundColor: 'rgba(13,148,136,0.08)',
                tension: 0.4, fill: true, pointRadius: 4, pointBackgroundColor: '#0d9488',
            },{
                label: 'Kehadiran Guru (%)',
                data: [92, 94, 90, 93, 95, 0],
                borderColor: '#22a85d', backgroundColor: 'rgba(34,168,93,0.06)',
                tension: 0.4, fill: true, pointRadius: 4, pointBackgroundColor: '#22a85d',
            }]
        },
        options: { responsive:true, plugins:{ legend:{ labels:{ font } } }, scales:{ y:{ min:0,max:100, ticks:{ font, callback:v=>v+'%' } }, x:{ ticks:{font} } } }
    });
    new Chart(document.getElementById('chartMetode'), {
        type: 'doughnut',
        data: {
            labels: ['Ceramah','Diskusi','Presentasi','Praktik','PBL'],
            datasets: [{
                data: [35, 25, 18, 14, 8],
                backgroundColor: ['#22a85d','#0d9488','#7c3aed','#d97706','#dc2626'],
                borderWidth: 2, borderColor: '#fff',
            }]
        },
        options: { responsive:true, plugins:{ legend:{ position:'right', labels:{ font, boxWidth:12 } } } }
    });
}
</script>
@endpush



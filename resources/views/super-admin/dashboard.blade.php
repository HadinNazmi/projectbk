@extends('layout')
@section('title', 'Dashboard Super Admin')

@section('content')
@php
    $registrations = $registrations ?? collect();
    $schools = $schools ?? collect();
    $adminUsers = $adminUsers ?? collect();
    $verifiedCount = $schools->where('status', 'verified')->count();
    $pendingCount = $schools->whereIn('status', ['pending', 'review'])->count();
    $revisionCount = $schools->where('status', 'rejected')->count();
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('css/super-admin-dashboard.css') }}">
@endpush

<section class="admin-hero">
    <div>
        <h1>Dashboard Verifikasi Sekolah</h1>
        <p>Verifikasi sekolah yang ingin bergabung ke sistem, cek kelengkapan dokumen, aktifkan sekolah yang disetujui, dan pantau daftar sekolah terdaftar.</p>
    </div>
    <div class="admin-actions">
        <a href="{{ route('super-admin.schools.index', ['status' => 'pending']) }}" class="admin-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Verifikasi Baru
        </a>
        <a href="{{ route('super-admin.schools.export') }}" class="admin-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
            Ekspor Sekolah
        </a>
    </div>
</section>

@if(session('admin_credentials'))
<div class="card admin-credentials">
    <div class="admin-credentials-title">Akun admin sekolah berhasil dibuat</div>
    <div class="admin-credentials-grid">
        <div><strong>Sekolah:</strong> {{ session('admin_credentials.school') }}</div>
        <div><strong>Login:</strong> <a href="{{ session('admin_credentials.login_url') }}" class="success-link">{{ session('admin_credentials.login_url') }}</a></div>
        <div><strong>Username:</strong> {{ session('admin_credentials.username') }}</div>
        <div><strong>Password:</strong> {{ session('admin_credentials.password') }}</div>
    </div>
</div>
@endif

@if(session('success'))
<div class="card card-success">{{ session('success') }}</div>
@endif

<div class="stats-row wide-stats">
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/></svg>
        </div>
        <div>
            <div class="stat-label">Sekolah Terverifikasi</div>
            <div class="stat-val">{{ $verifiedCount }}</div>
            <div class="stat-sub">Sekolah aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
        </div>
        <div>
            <div class="stat-label">Pengajuan Baru</div>
            <div class="stat-val">{{ $pendingCount }}</div>
            <div class="stat-sub">Menunggu review</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 15h6"/></svg>
        </div>
        <div>
            <div class="stat-label">Dokumen Lengkap</div>
            <div class="stat-val">{{ $schools->count() ? round(($verifiedCount / max($schools->count(), 1)) * 100) : 0 }}%</div>
            <div class="stat-sub">Siap diverifikasi</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
        </div>
        <div>
            <div class="stat-label">Perlu Revisi</div>
            <div class="stat-val">{{ $revisionCount }}</div>
            <div class="stat-sub">Butuh perbaikan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head card-head-wrap">
        <div>
            <h3>Pengajuan Sekolah Masuk</h3>
            <div class="muted-note">Antrian sekolah yang perlu dicek sebelum diberi akses sistem</div>
        </div>
        <span class="pill pending">{{ $registrations->count() }} Pengajuan</span>
    </div>
    <div class="table-scroll">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Sekolah</th>
                    <th>Kota</th>
                    <th>Kepala Sekolah</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $registration)
                <tr>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->city }}</td>
                    <td>{{ $registration->principal_name ?? '-' }}</td>
                    <td>{{ $registration->created_at->format('d M Y') }}</td>
                    <td><span class="status-badge status-warn">{{ $registration->status }}</span></td>
                    <td>
                        <div class="action-row">
                            <a href="{{ route('super-admin.schools.edit', $registration) }}" class="admin-btn admin-btn-review">Review</a>
                            <form action="{{ route('super-admin.schools.approve', $registration) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="admin-btn admin-btn-approve" type="submit">Setujui</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="tbl-empty">Belum ada pengajuan sekolah.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-head card-head-wrap">
        <div>
            <h3>Akun Admin Sekolah</h3>
            <div class="muted-note">Pantau akun admin yang dibuat setelah sekolah disetujui dan status perubahan passwordnya</div>
        </div>
        <span class="pill live">{{ $adminUsers->count() }} Admin</span>
    </div>
    <div class="table-scroll">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th>Sekolah</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status Password</th>
                    <th>Terakhir Diganti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adminUsers as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->school?->name ?? '-' }}</td>
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if($admin->password_changed_at)
                            <span class="status-badge status-ok">Sudah diganti</span>
                        @else
                            <span class="status-badge status-warn">Password awal</span>
                        @endif
                    </td>
                    <td>{{ $admin->password_changed_at ? $admin->password_changed_at->diffForHumans() : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6"><div class="tbl-empty">Belum ada akun admin sekolah.</div></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="admin-grid">
    <div class="card">
        <div class="card-head card-head-between">
            <div>
                <h3>Kesehatan Sistem Sekolah</h3>
                <div class="muted-note">Komposisi status sekolah terdaftar</div>
            </div>
            <span class="pill live">Live Data</span>
        </div>
        <div class="card-body">
            <div class="school-health">
                <div class="donut">
                    <div class="donut-inner">
                        <div>
                            <strong>76%</strong>
                            <span>sehat</span>
                        </div>
                    </div>
                </div>
                <div class="health-list">
                    <div class="health-item"><span>Sekolah aktif dan sinkron</span><strong>18 sekolah</strong></div>
                    <div class="health-item"><span>Perlu pemantauan operator</span><strong>4 sekolah</strong></div>
                    <div class="health-item"><span>Tertinggal pengisian jurnal</span><strong>2 sekolah</strong></div>
                    <div class="health-item"><span>Rata-rata pengisian jurnal</span><strong>86%</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3>Aktivitas Terbaru</h3>
        </div>
        <div class="card-body">
            <div class="activity-list">
                <div class="activity"><div class="activity-dot"></div><div><p>MTsN 3 Pekanbaru menyelesaikan sinkronisasi jurnal hari ini.</p><span>2 menit lalu</span></div></div>
                <div class="activity"><div class="activity-dot activity-dot-amber"></div><div><p>MTs Al Hidayah belum mencapai target jurnal minimal.</p><span>34 menit lalu</span></div></div>
                <div class="activity"><div class="activity-dot"></div><div><p>Operator MTsN 2 Siak menambahkan 3 akun guru baru.</p><span>1 jam lalu</span></div></div>
                <div class="activity"><div class="activity-dot activity-dot-red"></div><div><p>MTs Darussalam terlambat sinkron lebih dari 2 jam.</p><span>2 jam lalu</span></div></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head card-head-wrap">
        <div>
            <h3>Daftar Sekolah Terdaftar</h3>
            <div class="muted-note">Data contoh untuk tampilan monitoring super admin</div>
        </div>
        <div class="filter-controls">
            <input class="form-control school-search" id="schoolSearch" type="text" placeholder="Cari sekolah">
            <select class="form-control school-status" id="schoolStatus">
                <option value="">Semua status</option>
                <option value="verified">Terverifikasi</option>
                <option value="pending">Menunggu</option>
                <option value="review">Review</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
    </div>
    <div class="table-scroll">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Sekolah</th>
                    <th>Kota</th>
                    <th>Guru</th>
                    <th>Siswa</th>
                    <th>Jurnal</th>
                    <th>Status</th>
                    <th>Sinkron</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schools as $school)
                @php
                    $statusClass = $school->status === 'verified' ? 'status-ok' : ($school->status === 'rejected' ? 'status-danger' : 'status-warn');
                @endphp
                <tr class="school-row" data-name="{{ strtolower($school->name) }}" data-status="{{ $school->status }}">
                    <td>
                        <div class="school-name">
                            <span>{{ $school->name }}</span>
                            <small>NPSN {{ $school->npsn ?? '-' }}</small>
                        </div>
                    </td>
                    <td>{{ $school->city }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <div class="progress-row">
                            <div class="progress"><span @class([$school->status === 'verified' ? 'bar-width-100' : 'bar-width-45'])></span></div>
                            <strong class="progress-value">{{ $school->status === 'verified' ? '100%' : '45%' }}</strong>
                        </div>
                    </td>
                    <td><span class="status-badge {{ $statusClass }}">{{ $school->status }}</span></td>
                    <td>{{ $school->updated_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7"><div class="tbl-empty">Belum ada sekolah terdaftar.</div></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const schoolSearch = document.getElementById('schoolSearch');
const schoolStatus = document.getElementById('schoolStatus');
function filterSchools() {
    const keyword = (schoolSearch?.value || '').toLowerCase();
    const status = schoolStatus?.value || '';
    document.querySelectorAll('.school-row').forEach(row => {
        const matchName = row.dataset.name.includes(keyword);
        const matchStatus = !status || row.dataset.status === status;
        row.style.display = matchName && matchStatus ? '' : 'none';
    });
}
schoolSearch?.addEventListener('input', filterSchools);
schoolStatus?.addEventListener('change', filterSchools);
</script>
@endpush



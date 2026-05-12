@extends('layout')
@section('title', 'Pengaturan Akun')

@section('content')
<div class="hero hero-spaced">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><path d="M12 17a2 2 0 0 0 2-2v-2a2 2 0 0 0-4 0v2a2 2 0 0 0 2 2Z"/><path d="M17 11V8a5 5 0 0 0-10 0v3"/><rect x="4" y="11" width="16" height="10" rx="2"/></svg>
        </div>
        <h1>Pengaturan Akun Admin</h1>
        <p>Ganti password awal yang diberikan Super Admin agar lebih mudah dan aman digunakan.</p>
    </div>
    <div class="hero-badge">
        <div class="hb-label">Username</div>
        <div class="hb-val">{{ $user->username }}</div>
    </div>
</div>

@if(session('success'))
<div class="card card-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="card card-error">{{ $errors->first() }}</div>
@endif

<div class="card">
    <div class="card-head">
        <h3>Ganti Password</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.account.password') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-row cols-2">
                <div class="form-group">
                    <label>Password Saat Ini</label>
                    <input class="form-control" type="password" name="current_password" autocomplete="current-password">
                </div>
                <div></div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input class="form-control" type="password" name="password" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password">
                </div>
            </div>

            <div class="btn-row">
                <button class="btn btn-primary btn-full" type="submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    Simpan Password Baru
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Kembali</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <h3>Status Perubahan</h3>
    </div>
    <div class="card-body status-body">
        @if($user->password_changed_at)
            Password terakhir diganti pada <strong>{{ $user->password_changed_at->format('d M Y H:i') }}</strong>.
        @else
            Password masih menggunakan password awal dari Super Admin.
        @endif
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Jurnal Mengajar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
<main class="page">
    <div class="corner-line one"></div>
    <div class="corner-line two"></div>
    <div class="corner-line three"></div>
    <div class="corner-line four"></div>

    <nav class="nav">
        <div class="brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24"><path d="M12 3 3 7.5v9L12 21l9-4.5v-9L12 3Zm0 2.7 6.2 3.1L12 11.9 5.8 8.8 12 5.7Zm-6.5 5.2 5.2 2.6v4.5l-5.2-2.6v-4.5Zm7.8 7.1v-4.5l5.2-2.6v4.5L13.3 18Z"/></svg>
            </div>
            <span>Sistem Absensi Sekolah</span>
        </div>
        <div class="nav-actions">
            <a href="{{ route('school.register') }}" class="pill primary">Register Sekolah</a>
        </div>
    </nav>

    <section class="hero">
        <div class="orbit-logo">
            <svg viewBox="0 0 24 24"><path d="M12 3 3 7.5v9L12 21l9-4.5v-9L12 3Zm0 2.7 6.2 3.1L12 11.9 5.8 8.8 12 5.7Zm-6.5 5.2 5.2 2.6v4.5l-5.2-2.6v-4.5Zm7.8 7.1v-4.5l5.2-2.6v4.5L13.3 18Z"/></svg>
        </div>
        <h1>Kelola Jurnal. Pantau Sekolah.</h1>
        <p class="lead">Satu sistem untuk super admin memverifikasi sekolah, admin memantau aktivitas guru, dan guru mengisi jurnal mengajar secara cepat, bersih, dan real-time.</p>
        <div class="hero-cta">
            <a href="{{ route('login') }}" class="pill primary">Login</a>
        </div>
        <div class="spark-lines"><span></span><span></span><span></span></div>
        <p class="bottom-note">Dipakai untuk memusatkan jurnal harian, rekap kehadiran, dan status aktivitas sekolah dalam satu panel.</p>
    </section>
</main>
</body>
</html>


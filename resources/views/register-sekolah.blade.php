<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Sekolah - Sistem Absensi Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register-school.css') }}">
</head>
<body>
<main class="wrap">
    <nav class="nav">
        <a href="{{ route('landing') }}" class="brand">
            <span class="brand-mark">
                <svg viewBox="0 0 24 24"><path d="M12 3 3 7.5v9L12 21l9-4.5v-9L12 3Zm0 2.7 6.2 3.1L12 11.9 5.8 8.8 12 5.7Zm-6.5 5.2 5.2 2.6v4.5l-5.2-2.6v-4.5Zm7.8 7.1v-4.5l5.2-2.6v4.5L13.3 18Z"/></svg>
            </span>
            Sistem Absensi Sekolah
        </a>
        <a href="{{ route('landing') }}" class="back">Kembali</a>
    </nav>

    <section class="hero">
        <h1>Register Sekolah</h1>
        <p>Daftarkan sekolah agar dapat diverifikasi oleh super admin. Setelah disetujui, admin sekolah dapat mengelola guru, absensi, jurnal, dan laporan aktivitas.</p>
    </section>

    <section class="grid">
        <form class="card" action="{{ route('school.register.store') }}" method="POST">
            @csrf
            <div class="card-head">Data Sekolah</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="success-box">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="error-box">{{ $errors->first() }}</div>
                @endif
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: MTs Nurul Ilmi">
                    </div>
                    <div class="form-group">
                        <label>NPSN</label>
                        <input type="text" name="npsn" value="{{ old('npsn') }}" placeholder="Masukkan NPSN">
                    </div>
                    <div class="form-group">
                        <label>Kota/Kabupaten</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="Contoh: Pekanbaru">
                    </div>
                    <div class="form-group">
                        <label>Jenjang</label>
                        <select name="level">
                            <option @selected(old('level') === 'SD/MI')>SD/MI</option>
                            <option @selected(old('level') === 'SMP/MTs')>SMP/MTs</option>
                            <option @selected(old('level') === 'SMA/MA/SMK')>SMA/MA/SMK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Kepala Sekolah</label>
                        <input type="text" name="principal_name" value="{{ old('principal_name') }}" placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label>Email Admin Sekolah</label>
                        <input type="email" name="admin_email" value="{{ old('admin_email') }}" placeholder="admin@sekolah.sch.id">
                    </div>
                    <div class="form-group full">
                        <label>Alamat Sekolah</label>
                        <textarea name="address" placeholder="Tuliskan alamat lengkap sekolah">{{ old('address') }}</textarea>
                    </div>
                </div>
                <button class="btn" type="submit">Kirim Pengajuan</button>
            </div>
        </form>

        <aside class="card">
            <div class="card-head">Alur Verifikasi</div>
            <div class="card-body">
                <div class="steps">
                    <div class="step"><div class="step-no">1</div><div><strong>Kirim data sekolah</strong><span>Lengkapi identitas sekolah dan kontak admin.</span></div></div>
                    <div class="step"><div class="step-no">2</div><div><strong>Super admin memeriksa</strong><span>Dokumen dan data sekolah masuk ke dashboard verifikasi.</span></div></div>
                    <div class="step"><div class="step-no">3</div><div><strong>Akses diaktifkan</strong><span>Jika disetujui, sekolah mendapat akses admin untuk mulai memakai sistem.</span></div></div>
                </div>
            </div>
        </aside>
    </section>
</main>
</body>
</html>


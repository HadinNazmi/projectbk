@extends('layout')
@section('title', 'Input Jurnal')

@section('content')

{{-- HERO --}}
<div class="hero" style="background: linear-gradient(135deg, #156b42 0%, #22a85d 100%);">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
        </div>
        <h1>Input Jurnal Mengajar</h1>
        <p>Catat kegiatan pembelajaran, absensi siswa, dan dokumentasi kelas</p>
    </div>
    <div class="hero-badge">
        <div class="hb-label">Status Sistem</div>
        <div class="hb-val" style="color:#4ade80;">● Siap Digunakan</div>
    </div>
</div>

{{-- FORM --}}
<form action="#" method="POST" enctype="multipart/form-data" id="formJurnal">
@csrf

{{-- STEP 1: Informasi Dasar --}}
<div class="card">
    <div class="card-head">
        <div class="step-num" style="background:var(--green-mid);">1</div>
        <h3>Informasi Dasar</h3>
    </div>
    <div class="card-body">
        <div class="form-row cols-2">
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tanggal
                </label>
                <input type="date" class="form-control" name="tanggal" id="tgl" value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Hari
                </label>
                <input type="text" class="form-control" id="hari" readonly style="background:#f0f0eb; color:var(--gray-600);">
            </div>
        </div>
    </div>
</div>

{{-- STEP 2: Jam Pelajaran --}}
<div class="card">
    <div class="card-head">
        <div class="step-num" style="background:#7c3aed;">2</div>
        <h3>Jam Pelajaran</h3>
    </div>
    <div class="card-body">
        <div class="jam-grid">
            @for($i = 1; $i <= 10; $i++)
            <div class="jam-btn" onclick="selectJam(this, {{ $i }})" data-jam="{{ $i }}">
                <div class="num">{{ $i }}</div>
                <div class="lbl">Jam {{ $i }}</div>
            </div>
            @endfor
        </div>
        <input type="hidden" name="jam_pelajaran" id="inputJam">
    </div>
</div>

{{-- STEP 3: Detail Pembelajaran --}}
<div class="card">
    <div class="card-head">
        <div class="step-num" style="background:#0369a1;">3</div>
        <h3>Detail Pembelajaran</h3>
    </div>
    <div class="card-body">
        <div class="form-row cols-3">
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Guru Pengajar
                </label>
                <select class="form-control" name="guru">
                    <option value="">Pilih Guru</option>
                    <option>Bu Rina Handayani</option>
                    <option>Pak Dedi Kurniawan</option>
                    <option>Bu Sari Wulandari</option>
                    <option>Pak Andi Saputra</option>
                    <option>Bu Lena Marliana</option>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Kelas
                </label>
                <select class="form-control" name="kelas" id="selectKelas" onchange="loadSiswa(this.value)">
                    <option value="">Pilih Kelas</option>
                    <option>VII.1</option><option>VII.2</option><option>VII.3</option>
                    <option>VIII.1</option><option>VIII.2</option><option>VIII.3</option>
                    <option>IX.1</option><option>IX.2</option><option>IX.3</option>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Mata Pelajaran
                </label>
                <select class="form-control" name="mapel">
                    <option value="">Pilih Mata Pelajaran</option>
                    <option>Matematika</option><option>Bahasa Indonesia</option>
                    <option>Bahasa Inggris</option><option>IPA</option><option>IPS</option>
                    <option>PAI</option><option>PKn</option><option>Seni Budaya</option>
                    <option>Penjaskes</option><option>Prakarya</option>
                </select>
            </div>
        </div>
        <div class="form-row cols-12">
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Materi Pembelajaran
                </label>
                <textarea class="form-control" name="materi" placeholder="Tuliskan materi yang diajarkan hari ini..."></textarea>
            </div>
            <div class="form-group">
                <label>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Metode Pembelajaran
                </label>
                <select class="form-control" name="metode">
                    <option value="">Pilih Metode</option>
                    <option>Ceramah</option><option>Diskusi</option>
                    <option>Presentasi</option><option>Praktik Langsung</option>
                    <option>Project Based Learning</option><option>Problem Based Learning</option>
                    <option>Cooperative Learning</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- STEP 4: Dokumentasi Foto --}}
<div class="card">
    <div class="card-head">
        <div class="step-num" style="background:#d97706;">4</div>
        <h3>Dokumentasi Foto</h3>
    </div>
    <div class="card-body">
        <div class="foto-drop" id="fotoDrop">
            <input type="file" name="foto[]" accept="image/*" multiple id="fotoInput" onchange="previewFoto(this)">
            <div class="drop-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div class="drop-text">Klik atau seret foto ke sini</div>
            <div class="drop-sub">PNG, JPG, HEIC hingga 5MB per file · Maksimal 5 foto</div>
        </div>
        <div class="foto-preview" id="fotoPreview"></div>
    </div>
</div>

{{-- STEP 5: Absen Siswa --}}
<div class="card" id="cardAbsen" style="display:none;">
    <div class="card-head">
        <div class="step-num" style="background:#dc2626;">5</div>
        <h3>Absensi Siswa <span id="labelKelas" style="font-weight:400;color:var(--gray-400);font-size:13px;"></span></h3>
        <div style="margin-left:auto;display:flex;gap:10px;align-items:center;">
            <button type="button" class="btn btn-outline" style="padding:6px 12px;font-size:12px;" onclick="setAllAbsen('H')">✓ Hadir Semua</button>
        </div>
    </div>
    <div class="absen-header">
        <div>No</div><div>Nama Siswa</div>
        <div style="text-align:center">H</div>
        <div style="text-align:center">S</div>
        <div style="text-align:center">I</div>
        <div style="text-align:center">A</div>
    </div>
    <div id="absenList"></div>
    <div style="padding:12px 16px;background:#f7f8f7;border-top:1px solid var(--gray-100);display:flex;gap:16px;font-size:12px;color:var(--gray-600);">
        <span style="display:flex;align-items:center;gap:4px;"><span style="width:10px;height:10px;border-radius:2px;background:#dcfce7;display:inline-block;border:1px solid #16a34a;"></span> H = Hadir</span>
        <span style="display:flex;align-items:center;gap:4px;"><span style="width:10px;height:10px;border-radius:2px;background:#fef9c3;display:inline-block;border:1px solid #ca8a04;"></span> S = Sakit</span>
        <span style="display:flex;align-items:center;gap:4px;"><span style="width:10px;height:10px;border-radius:2px;background:#dbeafe;display:inline-block;border:1px solid #2563eb;"></span> I = Izin</span>
        <span style="display:flex;align-items:center;gap:4px;"><span style="width:10px;height:10px;border-radius:2px;background:#fee2e2;display:inline-block;border:1px solid #dc2626;"></span> A = Alfa</span>
    </div>
</div>

{{-- SUBMIT --}}
<div class="btn-row">
    <button type="submit" class="btn btn-primary btn-full">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Submit Jurnal
    </button>
    <button type="button" class="btn btn-outline" onclick="document.getElementById('formJurnal').reset(); document.querySelector('.foto-preview').innerHTML=''; document.querySelectorAll('.jam-btn').forEach(b=>b.classList.remove('selected')); document.getElementById('cardAbsen').style.display='none';">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.15"/></svg>
        Reset Form
    </button>
</div>

</form>
@endsection

@push('scripts')
<script>
// Hari otomatis
const hariList = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
function updateHari() {
    const tgl = document.getElementById('tgl').value;
    if (tgl) {
        const d = new Date(tgl);
        document.getElementById('hari').value = hariList[d.getDay()];
    }
}
document.getElementById('tgl').addEventListener('change', updateHari);
updateHari();

// Jam picker
function selectJam(el, num) {
    document.querySelectorAll('.jam-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('inputJam').value = num;
}

// Preview foto
function previewFoto(input) {
    const prev = document.getElementById('fotoPreview');
    prev.innerHTML = '';
    Array.from(input.files).slice(0,5).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'foto-thumb';
            prev.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

// Data siswa dummy per kelas
const dataSiswa = {
    'VII.1': ['Ahmad Fadhli','Budi Santoso','Citra Dewi','Dina Rahayu','Eko Prasetyo','Fani Rahmawati','Gilang Permana','Hana Novita','Irfan Hakim','Jeni Lestari','Kevin Andrean','Laila Sari','Muhamad Rizki','Nadia Putri','Omar Faruq'],
    'VII.2': ['Putri Andini','Qori Amalia','Rendi Pratama','Siti Khodijah','Taufik Hidayat','Uswatun Hasanah','Vina Melati','Wahyu Nugroho','Xena Putri','Yusuf Hamdani','Zahra Aulia','Aldi Kurniawan','Bella Safira','Chandra Putra','Devi Anggraini'],
    'VIII.1':['Elsa Nurhaliza','Farhan Baihaqi','Gina Aulia','Hendra Saputra','Ika Ramadhani','Joni Putra','Kartika Sari','Luthfi Hakim','Maya Indah','Nanda Firmansyah','Opik Suherman','Pita Listiana','Rini Agustina','Sandi Wicaksono','Tina Marlena'],
};

function loadSiswa(kelas) {
    const card = document.getElementById('cardAbsen');
    const list = document.getElementById('absenList');
    const label = document.getElementById('labelKelas');
    if (!kelas || !dataSiswa[kelas]) { card.style.display='none'; return; }
    label.textContent = '— ' + kelas;
    const siswa = dataSiswa[kelas];
    list.innerHTML = siswa.map((nama, i) => `
        <div class="absen-row">
            <div class="no">${i+1}</div>
            <div class="nama">${nama}</div>
            ${['H','S','I','A'].map(s => `
            <div class="absen-status">
                <input type="radio" name="absen_${i}" id="ab_${i}_${s}" value="${s}" ${s==='H'?'checked':''}>
                <label for="ab_${i}_${s}" class="${s}">${s}</label>
            </div>`).join('')}
        </div>`).join('');
    card.style.display = 'block';
}

function setAllAbsen(status) {
    document.querySelectorAll('input[type=radio][value='+status+']').forEach(r => r.checked = true);
}
</script>
@endpush
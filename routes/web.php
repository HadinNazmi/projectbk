<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\GuruAccountController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeachingJournalController;
use App\Models\School;
use App\Models\TeachingJournal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/register-sekolah', function () {
    return view('register-sekolah');
})->name('school.register');

Route::post('/register-sekolah', function (Request $request) {
    School::create($request->validate([
        'name' => ['required', 'string', 'max:255'],
        'npsn' => ['nullable', 'string', 'max:50'],
        'city' => ['required', 'string', 'max:120'],
        'level' => ['nullable', 'string', 'max:80'],
        'principal_name' => ['nullable', 'string', 'max:255'],
        'admin_email' => ['nullable', 'email', 'max:255'],
        'address' => ['nullable', 'string'],
    ]) + ['status' => 'pending']);

    return redirect()->route('school.register')->with('success', 'Pengajuan sekolah berhasil dikirim dan menunggu verifikasi super admin.');
})->name('school.register.store');

Route::get('/login/{role?}', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('super-admin.dashboard', [
            'registrations' => School::whereIn('status', ['pending', 'review'])->latest()->get(),
            'schools' => School::latest()->get(),
            'adminUsers' => User::with('school')->where('role', 'admin')->latest()->get(),
        ]);
    })->name('dashboard');

    Route::get('/schools/export', [SchoolController::class, 'export'])->name('schools.export');
    Route::patch('/schools/{school}/approve', [SchoolController::class, 'approve'])->name('schools.approve');
    Route::patch('/schools/{school}/reject', [SchoolController::class, 'reject'])->name('schools.reject');
    Route::resource('/schools', SchoolController::class)->names('schools');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/account', [AdminAccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account/password', [AdminAccountController::class, 'updatePassword'])->name('account.password');

    Route::resource('/teachers', TeacherController::class)->names('teachers');
    Route::resource('/classes', SchoolClassController::class)->names('classes');
    Route::resource('/subjects', SubjectController::class)->names('subjects');
    Route::resource('/students', StudentController::class)->names('students');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/input-jurnal', function () {
        return view('guru.input-jurnal');
    })->name('input-jurnal');

    Route::get('/journals/export', [TeachingJournalController::class, 'export'])->name('journals.export');
    Route::resource('/journals', TeachingJournalController::class)->names('journals');

    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');

    Route::get('/laporan', function () {
        $journals = TeachingJournal::with(['teacher', 'schoolClass', 'subject'])
            ->when(request('teacher_id'), fn ($query, $teacherId) => $query->where('teacher_id', $teacherId))
            ->when(request('date'), fn ($query, $date) => $query->whereDate('date', $date))
            ->latest()
            ->get();

        return view('guru.laporan', [
            'journals' => $journals,
            'teachers' => \App\Models\Teacher::orderBy('name')->get(),
        ]);
    })->name('laporan');

    Route::get('/setup', function () {
        return view('guru.setup');
    })->name('setup');

    Route::get('/account', [GuruAccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account/password', [GuruAccountController::class, 'updatePassword'])->name('account.password');
});

// Alias lama agar tautan yang sudah ada tetap bisa dibuka.
Route::redirect('/input-jurnal', '/guru/input-jurnal')->name('input-jurnal');
Route::redirect('/dashboard', '/guru/dashboard')->name('dashboard');
Route::redirect('/laporan', '/guru/laporan')->name('laporan');
Route::redirect('/setup', '/guru/setup')->name('setup');

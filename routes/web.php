<?php

use Illuminate\Support\Facades\Route;

// ── LOGIN ──────────────────────────────────────────────
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('input-jurnal');
})->name('login.post');

// ── HALAMAN UTAMA (pakai layout) ───────────────────────
Route::get('/input-jurnal', function () {
    return view('input-jurnal');
})->name('input-jurnal');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

Route::get('/setup', function () {
    return view('setup');
})->name('setup');
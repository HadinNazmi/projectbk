<?php

use Illuminate\Support\Facades\Route;

// Halaman login
Route::get('/', function () {
    return view('login');
})->name('login');

// POST login — sementara langsung redirect ke dashboard tanpa cek
Route::post('/login', function () {
    return redirect()->route('dashboard');
})->name('login.post');

// Halaman dashboard sementara
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
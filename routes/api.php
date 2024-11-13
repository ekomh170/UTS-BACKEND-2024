<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini sesuai dengan lokasi controller Anda
use App\Http\Controllers\NewsekoController;

// Route untuk registrasi pengguna baru
Route::post('/register', [AuthController::class, 'register']); // Registrasi pengguna

// Route untuk login
Route::post('/login', [AuthController::class, 'login']); // Login pengguna

// Mengelompokkan semua route di bawah middleware 'auth:sanctum' agar hanya bisa diakses oleh pengguna yang terautentikasi
Route::middleware('auth:sanctum')->group(function () {

    // Route resource untuk operasi CRUD dasar (index, store, show, update, destroy)
    Route::resource('news', NewsekoController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    // Route tambahan untuk pencarian berdasarkan judul
    Route::get('/news/search/{title}', [NewsekoController::class, 'search']);

    // Route tambahan untuk filter berita berdasarkan kategori
    Route::get('/news/category/{category}', [NewsekoController::class, 'getByCategory']);

    // Route untuk logout
    Route::post('/logout', [AuthController::class, 'logout']); // Logout pengguna
});

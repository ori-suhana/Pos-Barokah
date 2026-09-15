<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\CategoryController;
 

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');
 
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');
 
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


// route default
Route::get('/', function () {
    return view('welcome');
});

// --- PRAKTIKUM: Rute Dashboard ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/about', function () {
    return '<h1>Profil POS Barokah Mart</h1>
    <p>Selamat datang di aplikasi kasir Barokah Mart.</p>';
});

// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('report.sales');
    
    // 2. Tambahkan rute /users di sini:[cite: 1]
    Route::resource('users', UserController::class);
});
 
// --- RUTE ADMIN & KASIR ---
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
});
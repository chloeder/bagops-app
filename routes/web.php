<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::get('/forgot-password', [ResetPasswordController::class, 'forgot_password'])->name('forgot.password');
    Route::post('/forgot-password', [ResetPasswordController::class, 'send_link'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'reset_password'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update_password'])->name('password.update');
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan-berkas', [DashboardController::class, 'laporan_berkas'])->name('laporan.berkas');
    Route::get('/cetak-grafik', [DashboardController::class, 'cetak_grafik'])->name('cetak.grafik');
});

Route::middleware(['auth', 'role:admin'])->group(function () {


    //Kategori
    Route::get('/kategori', [DashboardController::class, 'view_kategori'])->name('kategori');
    Route::post('/kategori', [DashboardController::class, 'tambah_kategori'])->name('kategori.store');
    Route::delete('/kategori/{id}', [DashboardController::class, 'hapus_kategori'])->name('kategori.delete');
    Route::put('/kategori/status/{id}', [DashboardController::class, 'update_status_kategori'])->name('kategori.update.status');

    // Berkas
    Route::get('/berkas', [DashboardController::class, 'view_berkas'])->name('berkas');
    Route::post('/berkas', [DashboardController::class, 'tambah_berkas'])->name('berkas.store');

    // Dokumen
    Route::get('/dokumen/berkas', [DashboardController::class, 'view_dokumen'])->name('dokumen.berkas');
    // Route::get('/dokumen/detail/{id}', [DashboardController::class, 'detail_dokumen'])->name('dokumen.detail');
    Route::put('/dokumen/update/{id}', [DashboardController::class, 'update_dokumen'])->name('dokumen.update');
    Route::delete('/dokumen/berkas/{id}', [DashboardController::class, 'hapus_dokumen'])->name('dokumen.hapus');
    Route::put('/update/status/{id}', [DashboardController::class, 'update_status'])->name('update.status.dokumen');
    Route::get('/dokumen/berkas/tertunda', [DashboardController::class, 'view_tertunda'])->name('dokumen.berkas.tertunda');
    Route::get('/dokumen/berkas/ditolak', [DashboardController::class, 'view_ditolak'])->name('dokumen.berkas.ditolak');
    Route::get('download/{id}', [DashboardController::class, 'download_dokumen'])->name('dokumen.download');
    // Route::put('/dokumen/berkas/diterima/{id}', [DashboardController::class, 'update_status_diterima'])->name('update.status.diterima');
    // Route::put('/dokumen/berkas/terlambat/{id}', [DashboardController::class, 'update_status_terlambat'])->name('update.status.terlambat');

    // Settings
    Route::get('/user-list', [DashboardController::class, 'view_user'])->name('user.list');
    Route::put('/user-list/status/{id}', [DashboardController::class, 'update_status_user'])->name('update.status.user');
    Route::put('/user-list/wilayah/{id}', [DashboardController::class, 'update_wilayah_user'])->name('update.wilayah.user');
});

Route::middleware(['auth', 'role:user'])->group(function () {


    // Berkas
    Route::get('/berkas', [DashboardController::class, 'view_berkas'])->name('berkas');
    Route::post('/berkas', [DashboardController::class, 'tambah_berkas'])->name('berkas.store');

    //Settings
});

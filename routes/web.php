<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
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
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

    // Laporan
    Route::get('/laporan/berkas', [DashboardController::class, 'view_laporan'])->name('laporan.berkas');
    Route::get('/laporan/berkas/tertunda', [DashboardController::class, 'view_tertunda'])->name('laporan.berkas.tertunda');
    Route::put('/laporan/berkas/diterima/{id}', [DashboardController::class, 'update_status_diterima'])->name('update.status.diterima');
    Route::put('/laporan/berkas/terlambat/{id}', [DashboardController::class, 'update_status_terlambat'])->name('update.status.terlambat');
    Route::get('/laporan/berkas/terlambat', [DashboardController::class, 'view_terlambat'])->name('laporan.berkas.terlambat');
    Route::get('/laporan/detail/{id}', [DashboardController::class, 'detail_laporan'])->name('laporan.detail');

    // Settings
    Route::get('/user-list', [DashboardController::class, 'view_user'])->name('user.list');
    Route::put('/user-list/status/{id}', [DashboardController::class, 'update_status_user'])->name('update.status.user');
});

Route::middleware(['auth', 'role:user'])->group(function () {


    // Berkas
    Route::get('/berkas', [DashboardController::class, 'view_berkas'])->name('berkas');
    Route::post('/berkas', [DashboardController::class, 'tambah_berkas'])->name('berkas.store');
});

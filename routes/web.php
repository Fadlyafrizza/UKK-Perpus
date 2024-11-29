<?php

use App\Http\Controllers\dendaController;
use App\Http\Controllers\koleksiController;
use App\Http\Middleware\DashboardAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CekStatusBuku;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\pengembalianController;

Route::get('/', [MainController::class, 'index'])->name('home')->middleware(DashboardAuth::class);
Route::get('/peminjamanBuku/{Fadly_id}', [MainController::class, 'show'])->name('peminjaman.user.index')->middleware('auth');
Route::post('/peminjamanBuku', [MainController::class, 'store'])->name('peminjaman.user.store');
Route::get('/peminjamanBuku/koleksi/{Fadly_id}', [MainController::class, 'peminjaman'])->name('koleksi');

Route::get('/koleksi', [koleksiController::class, 'index'])->name('koleksi.index');
Route::delete('/koleksi/{Fadly_id}', [koleksiController::class, 'destroy'])->name('koleksi.destroy');

Route::get('/listPeminjaman', [pengembalianController::class, 'index'])->name('list.index');
Route::get('/listPeminjaman/{Fadly_id}/bukti', [pengembalianController::class, 'bukti'])->name('peminjaman.show');
Route::put('/listPeminjaman/{id}/return', [pengembalianController::class, 'return'])->name('peminjaman.return');

Route::get('/reviews/{peminjamanId}/create', [ReviewController::class, 'create'])->name('review.create');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('review.store');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    // dashboard index
    // Route::get('/dashboard', fn() => view('admin.index'))->name('dashboard');

    Route::get('/laporan/download-pdf', [LaporanController::class, 'downloadPdf'])->name('laporan.downloadPdf');


    Route::get('/dashboard', [MainController::class, 'admin'])->name('dashboard');

    // buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::get('/buku/{Fadly_buku}/update', [BukuController::class, 'edit'])->name('buku.edit');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/{Fadly_buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{Fadly_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::get('/kategori/{Fadly_kategori}/update', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{Fadly_kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{Fadly_kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // user
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/{Fadly_id}/update', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/{Fadly_id}/verify', [UserController::class, 'verify'])->name('user.verify');
    Route::put('/user/{Fadly_user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{Fadly_id}', [UserController::class, 'destroy'])->name('user.destroy');

    // peminjaman
    Route::get('/peminjaman', [PeminjamController::class, 'index'])->name('peminjaman.index');
    Route::get('/buku/{Fadly_id}/peminjaman', [PeminjamController::class, 'create'])->name('peminjaman.create')->middleware(CekStatusBuku::class);
    Route::post('/peminjaman/{Fadly_id}/verify', [PeminjamController::class, 'verify'])->name('peminjaman.verify');
    Route::post('/peminjaman/{Fadly_id}/kembali', [PeminjamController::class, 'update'])->name('peminjaman.update');
    Route::post('/peminjaman', [PeminjamController::class, 'store'])->name('peminjaman.store');
    Route::delete('/peminjaman/{Fadly_id}', [PeminjamController::class, 'destroy'])->name('peminjaman.destroy');
    Route::post('/peminjaman/{id}/create-denda', [PeminjamController::class, 'createDenda'])->name('peminjaman.create_denda');

    // activity
    Route::get('/activity', [LogAktivitasController::class, 'index'])->name('activity.index');

    // laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('', [LaporanController::class, 'index'])->name('index');
        Route::get('/users', [LaporanController::class, 'userReport'])->name('users');
        Route::get('/books', [LaporanController::class, 'bookReport'])->name('books');
        Route::get('/denda', [LaporanController::class, 'loanReport'])->name('denda');
        Route::get('/fines', [LaporanController::class, 'fineReport'])->name('fines');
        Route::get('/reviews', [LaporanController::class, 'reviewReport'])->name('reviews');
    });

    Route::get('/denda', [dendaController::class, 'index'])->name('denda.index');
    Route::post('/denda/{Fadly_id}', [dendaController::class, 'bayar'])->name('denda.bayar');
});

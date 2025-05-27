<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalpoliklinikController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DatauserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatapasienController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AntrianController;
use Illuminate\Support\Facades\Route;


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
});

//dashbrod
//admin route
Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
//route pasien
Route::get('/dashboard-pasien', [PasienController::class, 'index'])->name('dashboard-pasien');
//route petugas
Route::get('/dashboard-petugas', [PetugasController::class, 'index'])->name('dashboard-petugas');
//route poli
Route::get('/poliklinik', [PoliklinikController::class, 'index'])->name('poliklinik.index');
Route::get('/poliklinik/create', [PoliklinikController::class, 'create'])->name('poliklinik.create');
Route::post('poliklinik', [PoliklinikController::class, 'store'])->name('poliklinik.store');
Route::put('/poliklinik/update/{id}', [PoliklinikController::class, 'update'])->name('poliklinik.update');
Route::get('/poliklinik/edit/{id}', [PoliklinikController::class, 'edit'])->name('poliklinik.edit');
Route::delete('/poliklinik/{id}', [PoliklinikController::class, 'destroy'])->name('poliklinik.destroy');

//Dokter
Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
Route::get('/dokter/create', [DokterController::class, 'create'])->name('dokter.create');
Route::post('/dokter/add', [DokterController::class, 'add'])->name('dokter.add');
Route::delete('/dokter/{id}', [DokterController::class, 'destroy'])->name('dokter.destroy');
Route::get('/dokter/edit/{id}', [DokterController::class, 'edit'])->name('dokter.edit');
Route::put('/dokter/update/{id}', [DokterController::class, 'update'])->name('dokter.update');
Route::get('/dokter/{id}', [DokterController::class, 'show'])->name('dokter.show');

// Jadwal Poliklinik
Route::get('/jadwalpoliklinik', [JadwalPoliklinikController::class, 'index'])->name('jadwalpoliklinik.index');
Route::get('/jadwalpoliklinik/create', [JadwalPoliklinikController::class, 'create'])->name('jadwalpoliklinik.create');
Route::post('/jadwalpoliklinik/add', [JadwalPoliklinikController::class, 'add'])->name('jadwalpoliklinik.add');
Route::get('/jadwalpoliklinik/edit/{id}', [JadwalPoliklinikController::class, 'edit'])->name('jadwalpoliklinik.edit');
Route::put('/jadwalpoliklinik/update/{id}', [JadwalPoliklinikController::class, 'update'])->name('jadwalpoliklinik.update');
Route::delete('/jadwalpoliklinik/{id}', [JadwalPoliklinikController::class, 'destroy'])->name('jadwalpoliklinik.destroy');

// Route untuk login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::middleware(['redirect.if.authenticated'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Tambahkan rute lain yang ingin Anda lindungi
});

// Route untuk login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Route untuk logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


// Route untuk register
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('register', [LoginController::class, 'register']);

// User
Route::get('/user', [DatauserController::class, 'index'])->name('user.index');
Route::get('/user/create', [DatauserController::class, 'create'])->name('user.create');
Route::post('/user/add', [DatauserController::class, 'add'])->name('user.add');
Route::get('/user/{id}/edit', [DatauserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [DatauserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [DatauserController::class, 'destroy'])->name('user.destroy');

// Profile
// Rute untuk menampilkan halaman profil pengguna yang sedang login
Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
// Rute untuk memperbarui profil pengguna
Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');

// Pasien
Route::middleware('auth')->group(function () {
    Route::get('/datapribadi/{id}', [DatapasienController::class, 'show'])->name('pasien.show');
    Route::get('/datapribadi/{id}/edit', [DatapasienController::class, 'edit'])->name('pasien.edit');
    Route::put('/datapribadi/{id}', [DatapasienController::class, 'update'])->name('pasien.update');
});

Route::get('/datapasien', [DatapasienController::class, 'index'])->name('pasien.index');
Route::delete('/datapasien/{id}', [DatapasienController::class, 'destroy'])->name('pasien.destroy');

Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');

Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Antrian
Route::get('/antrianpendaftaran', [AntrianController::class, 'index'])->name('antrian.index');
Route::get('/antrianpendaftaran/pasien', [AntrianController::class, 'index2'])->name('antrian.index2');
Route::get('/riwayat-pasien', [AntrianController::class, 'index2'])->name('riwayat.pasien');
Route::get('/generate-antrian/{id}', [AntrianController::class, 'generateAntrian'])->name('generate.antrian');
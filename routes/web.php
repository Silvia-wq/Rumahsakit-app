<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliklinikController;

// Dashboard
// Route untuk admin
Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
// Route untuk petugas
Route::get('/dashboard-petugas', [PetugasController::class, 'index'])->name('dashboard-petugas');
// Route untuk pasien
Route::get('/dashboard-pasien', [PasienController::class, 'index'])->name('dashboard-pasien');

// Poliklinik
Route::get('/poliklinik/create', [PoliklinikController::class, 'create'])->name('poliklinik.create');
Route::post('/poliklinik/add', [PoliklinikController::class, 'add'])->name('poliklinik.add');
Route::get('/poliklinik', [PoliklinikController::class, 'index'])->name('poliklinik.index');
Route::get('/poliklinik/edit/{id}', [PoliklinikController::class, 'edit'])->name('poliklinik.edit');
Route::put('/poliklinik/update/{id}', [PoliklinikController::class, 'update'])->name('poliklinik.update');
Route::delete('/poliklinik/{id}', [PoliklinikController::class, 'destroy'])->name('poliklinik.destroy');


Route::get('/', function () {
    return view('welcome');
});

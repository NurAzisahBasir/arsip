<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 1. Setiap ada yang akses URL utama ('/'), langsung lempar ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Semua halaman aplikasi (arsip, dashboard, dll) dimasukkan ke dalam grup middleware auth
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [ArchiveController::class, 'index'])->name('dashboard');
    Route::get('/search', [ArchiveController::class, 'search'])->name('archives.search');
    Route::get('/kecamatan/{kecamatan}/kelurahan', [ArchiveController::class, 'kelurahans'])->name('archives.kelurahans.index');
    Route::get('/kelurahan/{kelurahan}/rak', [ArchiveController::class, 'raks'])->name('archives.raks.index');
    Route::get('/rak/{rak}/boks', [ArchiveController::class, 'boks'])->name('archives.boks.index');
    Route::get('/boks/{boks}/arsip', [ArchiveController::class, 'arsips'])->name('archives.arsips.index');

});

require __DIR__.'/auth.php';

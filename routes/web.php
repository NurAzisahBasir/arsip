<?php

use App\Http\Controllers\ProfileController;
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
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Masukkan route arsip atau halaman lainnya di sini
    // Example:
    // Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');

});

require __DIR__.'/auth.php';

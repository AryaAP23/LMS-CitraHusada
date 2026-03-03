<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/pembelajaran', function () {
        return view('pembelajaran');
    });

    Route::get('/belum-mulai', function () {
        return view('belum-mulai');
    });

    Route::get('/materi-progress', function () {
        return view('materi-progress');
    });
});
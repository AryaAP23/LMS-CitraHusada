<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/', function () {
    return "Login berhasil (sementara)";
})->name('login.post');

Route::get('/pembelajaran', function () {
    return view('pembelajaran');
});

Route::get('/belum-mulai', function () {
    return view('belum-mulai');
});

Route::get('/materi-progress', function () {
    return view('materi-progress');
});
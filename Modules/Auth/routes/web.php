<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('auths', AuthController::class)->names('auth');
});


Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('auth.login.process');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::middleware('auth.session')->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');
});

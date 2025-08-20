<?php

use Illuminate\Support\Facades\Route;
use Modules\MasterLocation\Http\Controllers\MasterLocationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('masterlocations', MasterLocationController::class)->names('masterlocation');
});


// Route::prefix('/admin')->middleware('auth.session')->group(function () {
//     Route::get('master-location', [MasterLocationController::class, 'index'])
//         ->name('masterlocation.index');
// });


// Route::prefix('/admin')->group(function () {
//     Route::get('master-location', [MasterLocationController::class, 'index'])
//         ->name('masterlocation.index');
//     Route::prefix('admin')->group(function () {
//         Route::post('master-location', [MasterLocationController::class, 'store'])->name('masterlocation.store');
//     });

//     Route::put('master-location/{id}', [MasterLocationController::class, 'update'])
//         ->name('masterlocation.update');
//     Route::delete('master-location/{id}', [MasterLocationController::class, 'destroy'])
//         ->name('masterlocation.destroy');
// });

Route::prefix('admin')->group(function () {
    Route::get('master-location', [MasterLocationController::class, 'index'])->name('masterlocation.index');
    Route::post('master-location', [MasterLocationController::class, 'store'])->name('masterlocation.store');
    Route::put('master-location/{id}', [MasterLocationController::class, 'update'])->name('masterlocation.update');
    Route::delete('master-location/{id}', [MasterLocationController::class, 'destroy'])->name('masterlocation.destroy');
});

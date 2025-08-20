<?php

use Illuminate\Support\Facades\Route;
use Modules\Monitoring\Http\Controllers\MonitoringController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('monitorings', MonitoringController::class)->names('monitoring');
});


Route::prefix('/admin')->group(function () {
    Route::get('monitoring', [MonitoringController::class, 'index'])
        ->name('masterlocation.index');
    Route::post('monitoring', [MonitoringController::class, 'store'])
        ->name('masterlocation.store');
    Route::put('monitoring/{id}', [MonitoringController::class, 'update'])
        ->name('masterlocation.update');
    Route::delete('monitoring/{id}', [MonitoringController::class, 'destroy'])
        ->name('masterlocation.destroy');
});

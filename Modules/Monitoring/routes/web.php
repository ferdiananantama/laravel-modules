<?php

use Illuminate\Support\Facades\Route;
use Modules\Monitoring\Http\Controllers\MonitoringController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('monitorings', MonitoringController::class)->names('monitoring');
});


// Route::prefix('/admin')->group(function () {
//     Route::get('monitoring', [MonitoringController::class, 'index'])
//         ->name('monitoring.index');
//     Route::post('monitoring', [MonitoringController::class, 'store'])
//         ->name('monitoring.store');
//     Route::put('monitoring/{id}', [MonitoringController::class, 'update'])
//         ->name('monitoring.update');
//     Route::delete('monitoring/{id}', [MonitoringController::class, 'destroy'])
//         ->name('monitoring.destroy');
// });

Route::prefix('admin')->group(function () {
    Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::post('monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::put('monitoring/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::delete('monitoring/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
    Route::get('monitoring-export', [MonitoringController::class, 'exportExcel'])->name('monitoring.export');
    Route::post('monitoring-import', [MonitoringController::class, 'importExcel'])->name('monitoring.import');
});

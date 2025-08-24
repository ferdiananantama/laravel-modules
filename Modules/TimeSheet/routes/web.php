<?php

use Illuminate\Support\Facades\Route;
use Modules\TimeSheet\Http\Controllers\TimeSheetController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('timesheets', TimeSheetController::class)->names('timesheet');
// });

Route::prefix('admin')->group(function () {
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet.index');
    Route::post('/timesheet', [TimesheetController::class, 'store'])->name('timesheet.store');
});

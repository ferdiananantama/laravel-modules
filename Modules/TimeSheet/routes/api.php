<?php

use Illuminate\Support\Facades\Route;
use Modules\TimeSheet\Http\Controllers\TimeSheetController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('timesheets', TimeSheetController::class)->names('timesheet');
});

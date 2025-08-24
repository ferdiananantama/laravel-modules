<?php

use Illuminate\Support\Facades\Route;
use Modules\Hours\Http\Controllers\HoursController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('hours', HoursController::class)->names('hours');
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Hours\Http\Controllers\HoursController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('hours', HoursController::class)->names('hours');
});

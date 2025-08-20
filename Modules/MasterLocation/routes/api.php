<?php

use Illuminate\Support\Facades\Route;
use Modules\MasterLocation\Http\Controllers\MasterLocationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('masterlocations', MasterLocationController::class)->names('masterlocation');
});

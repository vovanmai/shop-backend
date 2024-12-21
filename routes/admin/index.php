<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:admin', 'scope:user'])->group( function () {
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

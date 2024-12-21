<?php

use App\Http\Controllers\User\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('permissions')->group(function () {
    Route::get('', [PermissionController::class, 'index']);
});

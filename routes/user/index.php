<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::get('companies', [AuthController::class, 'getCompaniesByEmail']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink']);


Route::middleware(['auth:user'])->group( function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'getProfile']);
    Route::post('uploads', [CommonController::class, 'createUpload']);
    require __DIR__ . '/role.php';
    require __DIR__ . '/permission.php';
    require __DIR__ . '/user.php';
});

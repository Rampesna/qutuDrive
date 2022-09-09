<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\User\UserController::class, 'login'])->name('user.api.login');
    Route::post('sendPasswordResetEmail', [\App\Http\Controllers\Api\User\UserController::class, 'sendPasswordResetEmail'])->name('api.user.sendPasswordResetEmail');
    Route::post('resetPassword', [\App\Http\Controllers\Api\User\UserController::class, 'resetPassword'])->name('api.user.resetPassword');
});

Route::middleware([
    'auth:user_api',
])->group(function () {



});

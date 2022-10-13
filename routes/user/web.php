<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::get('login', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'login'])->name('user.web.authentication.login.index');
    Route::get('oAuth', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'oAuth'])->name('user.web.authentication.oAuth');
    Route::get('forgotPassword', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'forgotPassword'])->name('user.web.authentication.forgotPassword');
    Route::get('resetPassword/{token?}', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'resetPassword'])->name('user.web.authentication.resetPassword');
});

Route::middleware([
    'auth:user_web',
    'CheckLanguage'
])->group(function () {

    Route::put('changeLanguage', [\App\Http\Controllers\Web\User\LanguageController::class, 'changeLanguage'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('user.web.changeLanguage');
    Route::get('logout', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'logout'])->name('user.web.authentication.logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\DashboardController::class, 'index'])->name('user.web.dashboard.index');
    });

    Route::prefix('document')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\DocumentController::class, 'index'])->name('user.web.document.index');
    });

    Route::prefix('sharedDirectory')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\SharedDirectoryController::class, 'index'])->name('user.web.sharedDirectory.index');
    });

    Route::prefix('sharedWithMe')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\SharedWithMeController::class, 'index'])->name('user.web.sharedWithMe.index');
    });

    Route::prefix('qutuMail')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\QutuMailController::class, 'index'])->name('user.web.qutuMail.index');
    });

    Route::prefix('form')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\FormController::class, 'index'])->name('user.web.form.index');
    });

    Route::prefix('workFollow')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\WorkFollowController::class, 'index'])->name('user.web.workFollow.index');
        Route::get('overview/{id?}', [\App\Http\Controllers\Web\User\WorkFollowController::class, 'overview'])->name('user.web.workFollow.overview');
        Route::get('board/{id?}', [\App\Http\Controllers\Web\User\WorkFollowController::class, 'board'])->name('user.web.workFollow.board');
    });

    Route::prefix('calendar')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\CalendarController::class, 'index'])->name('user.web.calendar.index');
    });

    Route::prefix('password')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\PasswordController::class, 'index'])->name('user.web.password.index');
    });

    Route::prefix('note')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\NoteController::class, 'index'])->name('user.web.note.index');
    });

    Route::prefix('uploadRequest')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\UploadRequestController::class, 'index'])->name('user.web.uploadRequest.index');
    });

    Route::prefix('share')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\ShareController::class, 'index'])->name('user.web.share.index');
    });

    Route::prefix('userGroup')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\UserGroupController::class, 'index'])->name('user.web.userGroup.index');
    });

    Route::prefix('archiveGroup')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\ArchiveGroupController::class, 'index'])->name('user.web.archiveGroup.index');
    });

    Route::prefix('recycleBin')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\RecycleBinController::class, 'index'])->name('user.web.recycleBin.index');
    });

    Route::prefix('history')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\HistoryController::class, 'index'])->name('user.web.history.index');
    });

    Route::prefix('file')->group(function () {
        Route::get('download/{id?}', [\App\Http\Controllers\Web\User\FileController::class, 'download'])->name('user.web.file.download');
        Route::get('downloadByKey', [\App\Http\Controllers\Web\User\FileController::class, 'downloadByKey'])->name('user.web.file.downloadByKey');
        Route::get('createPdf/{id?}', [\App\Http\Controllers\Web\User\FileController::class, 'createPdf'])->name('user.web.file.createPdf');
    });
});

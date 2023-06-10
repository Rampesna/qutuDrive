<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::get('login', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'login'])->name('user.web.authentication.login.index');
    Route::get('register', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'register'])->name('user.web.authentication.register.index');
    Route::get('oAuth', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'oAuth'])->name('user.web.authentication.oAuth');
    Route::get('forgotPassword', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'forgotPassword'])->name('user.web.authentication.forgotPassword');
    Route::get('resetPassword/{token?}', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'resetPassword'])->name('user.web.authentication.resetPassword');
});

Route::middleware([
    'CheckLanguage'
])->group(function () {

    Route::put('changeLanguage', [\App\Http\Controllers\Web\User\LanguageController::class, 'changeLanguage'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('user.web.changeLanguage');
    Route::get('logout', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'logout'])->name('user.web.authentication.logout');
    Route::post('changeCompany', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'changeCompany'])->name('user.web.changeCompany');
    Route::prefix('dashboard')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\DashboardController::class, 'index'])->name('user.web.dashboard.index');
    });
    Route::prefix('panel')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\PanelController::class, 'index'])->name('user.web.panel.index');
    });

    Route::prefix('syncklasor')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\SyncklasorController::class, 'index'])->name('user.web.syncklasor.index');
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

    Route::prefix('databaseBackup')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\DatabaseBackupController::class, 'index'])->name('user.web.databaseBackup.index');
    });

    Route::prefix('eLedgerBackup')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\ELedgerBackupController::class, 'index'])->name('user.web.eLedgerBackup.index');
    });

    Route::prefix('form')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\FormController::class, 'index'])->name('user.web.form.index');
        Route::get('update/{id?}', [\App\Http\Controllers\Web\User\FormController::class, 'update'])->name('user.web.form.update');
        Route::get('report/{id?}', [\App\Http\Controllers\Web\User\FormController::class, 'report'])->name('user.web.form.report');
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
    Route::prefix('education/video')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\VideoController::class, 'index'])->name('user.web.video.index');
        Route::get('videolist', [\App\Http\Controllers\Web\User\VideoController::class, 'videoList'])->name('user.web.video.videolist.index');
    });
    Route::prefix('education/document')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\DocumentController::class, 'index'])->name('user.web.document.index');
        Route::get('documentlist', [\App\Http\Controllers\Web\User\DocumentController::class, 'documentList'])->name('user.web.document.documentlist.index');
    });

    Route::prefix('system')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Settings\UserController::class, 'index'])->name('user.web.system.settings.user.index');
            });

            Route::prefix('package')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Settings\PackageController::class, 'index'])->name('user.web.system.settings.package.index');
            });
        });

        Route::prefix('management')->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\UserController::class, 'index'])->name('user.web.system.management.user.index');

                Route::prefix('detail')->group(function () {
                    Route::get('index/{id?}', [\App\Http\Controllers\Web\User\System\Management\UserDetailController::class, 'index'])->name('user.web.system.management.user.detail.index');
                    Route::get('company/{id?}', [\App\Http\Controllers\Web\User\System\Management\UserDetailController::class, 'company'])->name('user.web.system.management.user.detail.company');
                });
            });

            Route::prefix('company')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\CompanyController::class, 'index'])->name('user.web.system.management.company.index');

                Route::prefix('detail')->group(function () {
                    Route::get('index/{id?}', [\App\Http\Controllers\Web\User\System\Management\CompanyDetailController::class, 'index'])->name('user.web.system.management.company.detail.index');
                    Route::get('package/{id?}', [\App\Http\Controllers\Web\User\System\Management\CompanyDetailController::class, 'package'])->name('user.web.system.management.company.detail.package');
                    Route::get('backupStatus/{id?}', [\App\Http\Controllers\Web\User\System\Management\CompanyDetailController::class, 'backupStatus'])->name('user.web.system.management.company.detail.backupStatus');
                    Route::get('eLedgerBackupStatus/{id?}', [\App\Http\Controllers\Web\User\System\Management\CompanyDetailController::class, 'eLedgerBackupStatus'])->name('user.web.system.management.company.detail.eLedgerBackupStatus');
                    Route::get('user/{id?}', [\App\Http\Controllers\Web\User\System\Management\CompanyDetailController::class, 'user'])->name('user.web.system.management.company.detail.user');
                });
            });


            Route::prefix('userCompanyConnection')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\UserCompanyConnectionController::class, 'index'])->name('user.web.system.management.userCompanyConnection.index');
            });

            Route::prefix('package')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\PackageController::class, 'index'])->name('user.web.system.management.package.index');
            });

            Route::prefix('packageConnection')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\PackageConnectionController::class, 'index'])->name('user.web.system.management.packageConnection.index');
            });

            Route::prefix('report')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\ReportController::class, 'index'])->name('user.web.system.management.report.index');
            });

            Route::prefix('gibELedger')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\GibELedgerController::class, 'index'])->name('user.web.system.management.gibELedger.index');
            });

            Route::prefix('petition')->group(function () {
                Route::get('index', [\App\Http\Controllers\Web\User\System\Management\PetitionController::class, 'index'])->name('user.web.system.management.petition.index');
            });
        });
    });
});

Route::prefix('file')->group(function () {
    Route::get('download/{id?}', [\App\Http\Controllers\Web\User\FileController::class, 'download'])->name('user.web.file.download');
    Route::get('downloadByKey', [\App\Http\Controllers\Web\User\FileController::class, 'downloadByKey'])->name('user.web.file.downloadByKey');
    Route::get('createPdf/{id?}', [\App\Http\Controllers\Web\User\FileController::class, 'createPdf'])->name('user.web.file.createPdf');
});

<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\User\UserController::class, 'login'])->name('user.api.login');
    Route::post('register', [\App\Http\Controllers\Api\User\UserController::class, 'register'])->name('user.api.register');
    Route::post('sendPasswordResetEmail', [\App\Http\Controllers\Api\User\UserController::class, 'sendPasswordResetEmail'])->name('api.user.sendPasswordResetEmail');
    Route::post('resetPassword', [\App\Http\Controllers\Api\User\UserController::class, 'resetPassword'])->name('api.user.resetPassword');
});

Route::middleware([
    'auth:user_api',
])->group(function () {

    Route::get('getProfile', [\App\Http\Controllers\Api\User\UserController::class, 'getProfile'])->name('user.api.getProfile');
    Route::get('getCompanies', [\App\Http\Controllers\Api\User\UserController::class, 'getCompanies'])->name('user.api.getCompanies');
    Route::post('setSelectedCompany', [\App\Http\Controllers\Api\User\UserController::class, 'setSelectedCompany'])->name('user.api.setSelectedCompany');
    Route::post('checkPassword', [\App\Http\Controllers\Api\User\UserController::class, 'checkPassword'])->name('user.api.checkPassword');

    Route::prefix('user')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\UserController::class, 'getAll'])->name('user.api.user.getAll');
        Route::get('jqxGrid', [\App\Http\Controllers\Api\User\UserController::class, 'jqxGrid'])->name('user.api.user.jqxGrid');
        Route::get('getByCompanyId', [\App\Http\Controllers\Api\User\UserController::class, 'getByCompanyId'])->name('user.api.user.getByCompanyId');
        Route::get('getByEmail', [\App\Http\Controllers\Api\User\UserController::class, 'getByEmail'])->name('user.api.user.getByEmail');
        Route::get('getByUsername', [\App\Http\Controllers\Api\User\UserController::class, 'getByUsername'])->name('user.api.user.getByUsername');
        Route::get('getById', [\App\Http\Controllers\Api\User\UserController::class, 'getById'])->name('user.api.user.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\UserController::class, 'create'])->name('user.api.user.create');
        Route::put('update', [\App\Http\Controllers\Api\User\UserController::class, 'update'])->name('user.api.user.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\UserController::class, 'delete'])->name('user.api.user.delete');
        Route::post('getUserPermission', [\App\Http\Controllers\Api\User\UserController::class, 'getUserPermission'])->name('user.api.user.getUserPermission');
        Route::get('getAllPermissions', [\App\Http\Controllers\Api\User\UserController::class, 'getAllPermissions'])->name('user.api.user.getAllPermissions');
        Route::post('setPermissions', [\App\Http\Controllers\Api\User\UserController::class, 'setPermissions'])->name('user.api.user.setPermissions');
        Route::post('changeEmail', [\App\Http\Controllers\Api\User\UserController::class, 'changeEmail'])->name('user.api.user.changeEmail');
    });

    Route::prefix('video')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\VideoController::class, 'getAll'])->name('user.api.video.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\VideoController::class, 'getById'])->name('user.api.video.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\VideoController::class, 'create'])->name('user.api.video.create');
        Route::put('update', [\App\Http\Controllers\Api\User\VideoController::class, 'update'])->name('user.api.video.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\VideoController::class, 'delete'])->name('user.api.video.delete');
    });
    Route::prefix('document')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\DocumentController::class, 'getAll'])->name('user.api.document.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\DocumentController::class, 'getById'])->name('user.api.document.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\DocumentController::class, 'create'])->name('user.api.document.create');
        Route::post('update', [\App\Http\Controllers\Api\User\DocumentController::class, 'update'])->name('user.api.document.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\DocumentController::class, 'delete'])->name('user.api.document.delete');
    });

    Route::prefix('company')->group(function () {
        Route::get('jqxGrid', [\App\Http\Controllers\Api\User\CompanyController::class, 'jqxGrid'])->name('user.api.company.jqxGrid');
        Route::get('getAll', [\App\Http\Controllers\Api\User\CompanyController::class, 'getAll'])->name('user.api.company.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\CompanyController::class, 'getById'])->name('user.api.company.getById');
        Route::get('getByTaxNumber', [\App\Http\Controllers\Api\User\CompanyController::class, 'getByTaxNumber'])->name('user.api.company.getByTaxNumber');
        Route::post('create', [\App\Http\Controllers\Api\User\CompanyController::class, 'create'])->name('user.api.company.create');
        Route::post('createBatch', [\App\Http\Controllers\Api\User\CompanyController::class, 'createBatch'])->name('user.api.company.createBatch');
        Route::put('update', [\App\Http\Controllers\Api\User\CompanyController::class, 'update'])->name('user.api.company.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\CompanyController::class, 'delete'])->name('user.api.company.delete');
    });

    Route::prefix('userCompanyConnection')->group(function () {
        Route::get('getUserCompanies', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'getUserCompanies'])->name('user.api.userCompanyConnection.getUserCompanies');
        Route::get('checkUserCompany', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'checkUserCompany'])->name('user.api.userCompanyConnection.checkUserCompany');
        Route::post('attachUserCompany', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'attachUserCompany'])->name('user.api.userCompanyConnection.attachUserCompany');
        Route::post('detachUserCompany', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'detachUserCompany'])->name('user.api.userCompanyConnection.detachUserCompany');
        Route::post('syncUserCompany', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'syncUserCompanies'])->name('user.api.userCompanyConnection.syncUserCompanies');
        Route::get('getCompanyUsers', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'getCompanyUsers'])->name('user.api.userCompanyConnection.getCompanyUsers');
        Route::post('attachCompanyUser', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'attachCompanyUser'])->name('user.api.userCompanyConnection.attachCompanyUser');
        Route::post('detachCompanyUser', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'detachCompanyUser'])->name('user.api.userCompanyConnection.detachCompanyUser');
        Route::post('syncCompanyUser', [\App\Http\Controllers\Api\User\UserCompanyConnectionController::class, 'syncCompanyUsers'])->name('user.api.userCompanyConnection.syncCompanyUsers');
    });

    Route::prefix('project')->group(function () {
        Route::get('index', [\App\Http\Controllers\Api\User\ProjectController::class, 'index'])->name('user.api.project.index');
        Route::get('getById', [\App\Http\Controllers\Api\User\ProjectController::class, 'getById'])->name('user.api.project.getById');
        Route::get('getAllTasks', [\App\Http\Controllers\Api\User\ProjectController::class, 'getAllTasks'])->name('user.api.project.getAllTasks');
        Route::get('getSubtasksByProjectId', [\App\Http\Controllers\Api\User\ProjectController::class, 'getSubtasksByProjectId'])->name('user.api.project.getSubtasksByProjectId');
        Route::get('getBoardsByProjectId', [\App\Http\Controllers\Api\User\ProjectController::class, 'getBoardsByProjectId'])->name('user.api.project.getBoardsByProjectId');
        Route::get('getUsersByProjectId', [\App\Http\Controllers\Api\User\ProjectController::class, 'getUsersByProjectId'])->name('user.api.project.getUsersByProjectId');
        Route::post('setUsersByProjectId', [\App\Http\Controllers\Api\User\ProjectController::class, 'setUsersByProjectId'])->name('user.api.project.setUsersByProjectId');
        Route::post('create', [\App\Http\Controllers\Api\User\ProjectController::class, 'create'])->name('user.api.project.create');
        Route::put('update', [\App\Http\Controllers\Api\User\ProjectController::class, 'update'])->name('user.api.project.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\ProjectController::class, 'delete'])->name('user.api.project.delete');
    });

    Route::prefix('projectStatus')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\ProjectStatusController::class, 'getAll'])->name('user.api.projectStatus.getAll');
    });

    Route::prefix('task')->group(function () {
        Route::get('getById', [\App\Http\Controllers\Api\User\TaskController::class, 'getById'])->name('user.api.task.getById');
        Route::get('getFilesById', [\App\Http\Controllers\Api\User\TaskController::class, 'getFilesById'])->name('user.api.task.getFilesById');
        Route::get('getSubTasksById', [\App\Http\Controllers\Api\User\TaskController::class, 'getSubTasksById'])->name('user.api.task.getSubTasksById');
        Route::get('getCommentsById', [\App\Http\Controllers\Api\User\TaskController::class, 'getCommentsById'])->name('user.api.task.getCommentsById');
        Route::post('create', [\App\Http\Controllers\Api\User\TaskController::class, 'create'])->name('user.api.task.create');
        Route::put('updateBoard', [\App\Http\Controllers\Api\User\TaskController::class, 'updateBoard'])->name('user.api.task.updateBoard');
        Route::put('updateOrder', [\App\Http\Controllers\Api\User\TaskController::class, 'updateOrder'])->name('user.api.task.updateOrder');
        Route::put('updateByParameters', [\App\Http\Controllers\Api\User\TaskController::class, 'updateByParameters'])->name('user.api.task.updateByParameters');
        Route::delete('delete', [\App\Http\Controllers\Api\User\TaskController::class, 'delete'])->name('user.api.task.delete');
    });

    Route::prefix('board')->group(function () {
        Route::post('create', [\App\Http\Controllers\Api\User\BoardController::class, 'create'])->name('user.api.board.create');
        Route::put('updateName', [\App\Http\Controllers\Api\User\BoardController::class, 'updateName'])->name('user.api.board.updateName');
        Route::put('updateOrder', [\App\Http\Controllers\Api\User\BoardController::class, 'updateOrder'])->name('user.api.board.updateOrder');
        Route::delete('delete', [\App\Http\Controllers\Api\User\BoardController::class, 'delete'])->name('user.api.board.delete');
    });

    Route::prefix('subTask')->group(function () {
        Route::get('getByProjectId', [\App\Http\Controllers\Api\User\SubTaskController::class, 'getByProjectId'])->name('user.api.subTask.getByProjectId');
        Route::get('getByProjectIds', [\App\Http\Controllers\Api\User\SubTaskController::class, 'getByProjectIds'])->name('user.api.subTask.getByProjectIds');
        Route::post('create', [\App\Http\Controllers\Api\User\SubTaskController::class, 'create'])->name('user.api.subTask.create');
        Route::put('update', [\App\Http\Controllers\Api\User\SubTaskController::class, 'update'])->name('user.api.subTask.update');
        Route::put('setChecked', [\App\Http\Controllers\Api\User\SubTaskController::class, 'setChecked'])->name('user.api.subTask.setChecked');
        Route::delete('delete', [\App\Http\Controllers\Api\User\SubTaskController::class, 'delete'])->name('user.api.subTask.delete');
    });

    Route::prefix('taskPriority')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\TaskPriorityController::class, 'getAll'])->name('user.api.taskPriority.getAll');
    });

    Route::prefix('note')->group(function () {
        Route::get('getByDateBetween', [\App\Http\Controllers\Api\User\NoteController::class, 'getByDateBetween'])->name('user.api.note.getByDateBetween');
        Route::get('getById', [\App\Http\Controllers\Api\User\NoteController::class, 'getById'])->name('user.api.note.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\NoteController::class, 'create'])->name('user.api.note.create');
        Route::put('update', [\App\Http\Controllers\Api\User\NoteController::class, 'update'])->name('user.api.note.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\NoteController::class, 'delete'])->name('user.api.note.delete');
    });

    Route::prefix('generalNote')->group(function () {
        Route::get('index', [\App\Http\Controllers\Api\User\GeneralNoteController::class, 'index'])->name('user.api.generalNote.index');
        Route::get('getById', [\App\Http\Controllers\Api\User\GeneralNoteController::class, 'getById'])->name('user.api.generalNote.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\GeneralNoteController::class, 'create'])->name('user.api.generalNote.create');
        Route::put('update', [\App\Http\Controllers\Api\User\GeneralNoteController::class, 'update'])->name('user.api.generalNote.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\GeneralNoteController::class, 'delete'])->name('user.api.generalNote.delete');
    });

    Route::prefix('form')->group(function () {
        Route::get('getByCompanyId', [\App\Http\Controllers\Api\User\FormController::class, 'getByCompanyId'])->name('user.api.form.getByCompanyId');
        Route::get('getById', [\App\Http\Controllers\Api\User\FormController::class, 'getById'])->name('user.api.form.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\FormController::class, 'create'])->name('user.api.form.create');
        Route::put('update', [\App\Http\Controllers\Api\User\FormController::class, 'update'])->name('user.api.form.update');
        Route::put('updateAccessible', [\App\Http\Controllers\Api\User\FormController::class, 'updateAccessible'])->name('user.api.form.updateAccessible');
        Route::post('createFormQuestions', [\App\Http\Controllers\Api\User\FormController::class, 'createFormQuestions'])->name('user.api.form.createFormQuestions');
        Route::delete('delete', [\App\Http\Controllers\Api\User\FormController::class, 'delete'])->name('user.api.form.delete');
        Route::get('getShareLink', [\App\Http\Controllers\Api\User\FormController::class, 'getShareLink'])->name('user.api.form.getShareLink');
    });

    Route::prefix('formQuestion')->group(function () {
        Route::get('getByFormIdWithAnswers', [\App\Http\Controllers\Api\User\FormQuestionController::class, 'getByFormIdWithAnswers'])->name('user.api.formQuestion.getByFormIdWithAnswers');
    });

    Route::prefix('formSubmit')->group(function () {
        Route::get('getByFormId', [\App\Http\Controllers\Api\User\FormSubmitController::class, 'getByFormId'])->name('user.api.formSubmit.getByFormId');
    });

    Route::prefix('password')->group(function () {
        Route::get('index', [\App\Http\Controllers\Api\User\PasswordController::class, 'index'])->name('user.api.password.index');
        Route::get('getById', [\App\Http\Controllers\Api\User\PasswordController::class, 'getById'])->name('user.api.password.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\PasswordController::class, 'create'])->name('user.api.password.create');
        Route::put('update', [\App\Http\Controllers\Api\User\PasswordController::class, 'update'])->name('user.api.password.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\PasswordController::class, 'delete'])->name('user.api.password.delete');
    });

    Route::prefix('file')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\FileController::class, 'getAll'])->name('user.api.file.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\FileController::class, 'getById'])->name('user.api.file.getById');
        Route::get('getByRelation', [\App\Http\Controllers\Api\User\FileController::class, 'getByRelation'])->name('user.api.file.getByRelation');
        Route::get('getTrashedByRelation', [\App\Http\Controllers\Api\User\FileController::class, 'getTrashedByRelation'])->name('user.api.file.getTrashedByRelation');
        Route::post('upload', [\App\Http\Controllers\Api\User\FileController::class, 'upload'])->name('user.api.file.upload');
        Route::post('uploadBatch', [\App\Http\Controllers\Api\User\FileController::class, 'uploadBatch'])->name('user.api.file.uploadBatch');
        Route::get('download', [\App\Http\Controllers\Api\User\FileController::class, 'download'])->name('user.api.file.download');
        Route::get('downloadSingleFile', [\App\Http\Controllers\Api\User\FileController::class, 'downloadSingleFile'])->name('user.api.file.downloadSingleFile');
        Route::put('updateDirectoryId', [\App\Http\Controllers\Api\User\FileController::class, 'updateDirectoryId'])->name('user.api.file.updateDirectoryId');
        Route::delete('delete', [\App\Http\Controllers\Api\User\FileController::class, 'delete'])->name('user.api.file.delete');
        Route::delete('deleteBatch', [\App\Http\Controllers\Api\User\FileController::class, 'deleteBatch'])->name('user.api.file.deleteBatch');
        Route::post('recover', [\App\Http\Controllers\Api\User\FileController::class, 'recover'])->name('user.api.file.recover');

        Route::get('getDatabaseBackups', [\App\Http\Controllers\Api\User\FileController::class, 'getDatabaseBackups'])->name('user.api.file.getDatabaseBackups');
    });

    Route::prefix('directory')->group(function () {
        Route::get('getByParentId', [\App\Http\Controllers\Api\User\DirectoryController::class, 'getByParentId'])->name('user.api.directory.getByParentId');
        Route::get('getTrashed', [\App\Http\Controllers\Api\User\DirectoryController::class, 'getTrashed'])->name('user.api.directory.getTrashed');
        Route::post('recoverTrashed', [\App\Http\Controllers\Api\User\DirectoryController::class, 'recoverTrashed'])->name('user.api.directory.recoverTrashed');
        Route::post('create', [\App\Http\Controllers\Api\User\DirectoryController::class, 'create'])->name('user.api.directory.create');
        Route::put('rename', [\App\Http\Controllers\Api\User\DirectoryController::class, 'rename'])->name('user.api.directory.rename');
        Route::put('updateParentId', [\App\Http\Controllers\Api\User\DirectoryController::class, 'updateParentId'])->name('user.api.directory.updateParentId');
        Route::delete('delete', [\App\Http\Controllers\Api\User\DirectoryController::class, 'delete'])->name('user.api.directory.delete');
        Route::delete('deleteBatch', [\App\Http\Controllers\Api\User\DirectoryController::class, 'deleteBatch'])->name('user.api.directory.deleteBatch');
        Route::post('recover', [\App\Http\Controllers\Api\User\DirectoryController::class, 'recover'])->name('user.api.directory.recover');
    });

    Route::prefix('comment')->group(function () {
        Route::get('getByRelation', [\App\Http\Controllers\Api\User\CommentController::class, 'getByRelation'])->name('user.api.comment.getByRelation');
        Route::post('create', [\App\Http\Controllers\Api\User\CommentController::class, 'create'])->name('user.api.comment.create');
    });

    Route::prefix('syncklasorler')->group(function () {
        Route::get('getByCompanyId', [\App\Http\Controllers\Api\User\SyncKlasorlerController::class, 'getByCompanyId'])->name('user.api.syncklasorler.getByCompanyId');
    });

    Route::prefix('syncdosyahareket')->group(function () {
        Route::get('getBySunucuKlasorId', [\App\Http\Controllers\Api\User\SyncDosyaHareketController::class, 'getBySunucuKlasorId'])->name('user.api.syncdosyahareket.getBySunucuKlasorId');
        Route::get('getUsage', [\App\Http\Controllers\Api\User\SyncDosyaHareketController::class, 'getUsage'])->name('user.api.syncdosyahareket.getUsage');
        Route::get('downloadSingleFile', [\App\Http\Controllers\Api\User\SyncDosyaHareketController::class, 'downloadSingleFile'])->name('user.api.syncdosyahareket.downloadSingleFile');
    });

    Route::prefix('edefterdonemler')->group(function () {
        Route::get('getEDefterDonem', [\App\Http\Controllers\Api\User\EDefterDonemlerController::class, 'getEDefterDonem'])->name('user.api.edefterdonemler.getEDefterDonem');
    });

    Route::prefix('edefterdosyalar')->group(function () {
        Route::get('getByDonemId', [\App\Http\Controllers\Api\User\EDefterDosyalarController::class, 'getByDonemId'])->name('user.api.edefterdosyalar.getByDonemId');
        Route::get('getByDatesAndTypeIds', [\App\Http\Controllers\Api\User\EDefterDosyalarController::class, 'getByDatesAndTypeIds'])->name('user.api.edefterdosyalar.getByDatesAndTypeIds');
        Route::get('getUsage', [\App\Http\Controllers\Api\User\EDefterDosyalarController::class, 'getUsage'])->name('user.api.edefterdosyalar.getUsage');
        Route::post('singleELedgerUpload', [\App\Http\Controllers\Api\User\EDefterDosyalarController::class, 'singleELedgerUpload'])->name('user.api.edefterdosyalar.singleELedgerUpload');
        Route::get('downloadSingleFile', [\App\Http\Controllers\Api\User\EDefterDosyalarController::class, 'downloadSingleFile'])->name('user.api.edefterdosyalar.downloadSingleFile');
    });

    Route::prefix('backupdosyalar')->group(function () {
        Route::get('getByCompanyId', [\App\Http\Controllers\Api\User\BackupDosyalarController::class, 'getByCompanyId'])->name('user.api.backupdosyalar.getByCompanyId');
        Route::get('getUsage', [\App\Http\Controllers\Api\User\BackupDosyalarController::class, 'getUsage'])->name('user.api.backupdosyalar.getUsage');
        Route::get('downloadSingleFile', [\App\Http\Controllers\Api\User\BackupDosyalarController::class, 'downloadSingleFile'])->name('user.api.backupdosyalar.downloadSingleFile');
    });

    Route::prefix('paketbilgileri')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\PaketBilgileriController::class, 'getAll'])->name('user.api.paketbilgileri.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\PaketBilgileriController::class, 'getById'])->name('user.api.paketbilgileri.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\PaketBilgileriController::class, 'create'])->name('user.api.paketbilgileri.create');
        Route::put('update', [\App\Http\Controllers\Api\User\PaketBilgileriController::class, 'update'])->name('user.api.paketbilgileri.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\PaketBilgileriController::class, 'delete'])->name('user.api.paketbilgileri.delete');
    });

    Route::prefix('firmapaketleri')->group(function () {
        Route::get('getByCompanyId', [\App\Http\Controllers\Api\User\FirmaPaketleriController::class, 'getByCompanyId'])->name('user.api.firmapaketleri.getByCompanyId');
        Route::get('getUsage', [\App\Http\Controllers\Api\User\FirmaPaketleriController::class, 'getUsage'])->name('user.api.firmapaketleri.getUsage');
        Route::post('create', [\App\Http\Controllers\Api\User\FirmaPaketleriController::class, 'create'])->name('user.api.firmapaketleri.create');
    });

    Route::prefix('gibsaklamaozelliste')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\GibSaklamaOzelListeController::class, 'getAll'])->name('user.api.gibsaklamaozelliste.getAll');
        Route::post('create', [\App\Http\Controllers\Api\User\GibSaklamaOzelListeController::class, 'create'])->name('user.api.gibsaklamaozelliste.create');
    });

    Route::prefix('waitingDatabaseBackupDownload')->group(function () {
        Route::get('getByUserId', [\App\Http\Controllers\Api\User\WaitingDatabaseBackupDownloadController::class, 'getByUserId'])->name('user.api.waitingDatabaseBackupDownload.getByUserId');
        Route::post('cancel', [\App\Http\Controllers\Api\User\WaitingDatabaseBackupDownloadController::class, 'cancel'])->name('user.api.waitingDatabaseBackupDownload.cancel');
    });

    Route::prefix('apiAyssoft')->group(function () {
        Route::prefix('BalanceInquiry')->group(function () {
            Route::get('Index', [\App\Http\Controllers\Api\User\ApiAyssoft\BalanceInquiryController::class, 'Index'])->name('user.api.apiAyssoft.BalanceInquiry.Index');
        });
    });
});

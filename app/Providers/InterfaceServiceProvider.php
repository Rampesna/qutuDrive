<?php

namespace App\Providers;

use App\Interfaces\AwsS3\IStorageService;
use App\Interfaces\Eloquent\IBackupDosyalarService;
use App\Interfaces\Eloquent\IBoardService;
use App\Interfaces\Eloquent\IDirectoryService;
use App\Interfaces\Eloquent\IEDefterDonemlerService;
use App\Interfaces\Eloquent\IEDefterDosyalarService;
use App\Interfaces\Eloquent\IFileService;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Interfaces\Eloquent\IFormQuestionService;
use App\Interfaces\Eloquent\IFormService;
use App\Interfaces\Eloquent\IFormSubmitService;
use App\Interfaces\Eloquent\IGeneralNoteService;
use App\Interfaces\Eloquent\INoteService;
use App\Interfaces\Eloquent\IPasswordResetService;
use App\Interfaces\Eloquent\IPasswordService;
use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use App\Interfaces\Eloquent\IProjectService;
use App\Interfaces\Eloquent\IProjectStatusService;
use App\Interfaces\Eloquent\ISubTaskService;
use App\Interfaces\Eloquent\ISyncDosyaHareketService;
use App\Interfaces\Eloquent\ISyncKlasorlerService;
use App\Interfaces\Eloquent\ITaskPriorityService;
use App\Interfaces\Eloquent\ITaskService;
use App\Interfaces\Eloquent\IUserService;
use App\Services\AwsS3\StorageService;
use App\Services\Eloquent\BackupDosyalarService;
use App\Services\Eloquent\BoardService;
use App\Services\Eloquent\DirectoryService;
use App\Services\Eloquent\EDefterDonemlerService;
use App\Services\Eloquent\EDefterDosyalarService;
use App\Services\Eloquent\FileService;
use App\Services\Eloquent\FirmalarService;
use App\Services\Eloquent\FormQuestionService;
use App\Services\Eloquent\FormService;
use App\Services\Eloquent\FormSubmitService;
use App\Services\Eloquent\GeneralNoteService;
use App\Services\Eloquent\PasswordResetService;
use App\Services\Eloquent\PasswordService;
use App\Services\Eloquent\PersonalAccessTokenService;
use App\Services\Eloquent\ProjectService;
use App\Services\Eloquent\ProjectStatusService;
use App\Services\Eloquent\SubTaskService;
use App\Services\Eloquent\SyncDosyaHareketService;
use App\Services\Eloquent\SyncKlasorlerService;
use App\Services\Eloquent\TaskPriorityService;
use App\Services\Eloquent\TaskService;
use App\Services\Eloquent\UserService;
use App\Services\Eloquent\NoteService;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Eloquent Services
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IPasswordResetService::class, PasswordResetService::class);
        $this->app->bind(IPersonalAccessTokenService::class, PersonalAccessTokenService::class);
        $this->app->bind(IProjectService::class, ProjectService::class);
        $this->app->bind(IProjectStatusService::class, ProjectStatusService::class);
        $this->app->bind(IBoardService::class, BoardService::class);
        $this->app->bind(ITaskService::class, TaskService::class);
        $this->app->bind(ITaskPriorityService::class, TaskPriorityService::class);
        $this->app->bind(ISubTaskService::class, SubTaskService::class);
        $this->app->bind(INoteService::class, NoteService::class);
        $this->app->bind(IFileService::class, FileService::class);
        $this->app->bind(IDirectoryService::class, DirectoryService::class);
        $this->app->bind(IGeneralNoteService::class, GeneralNoteService::class);
        $this->app->bind(IPasswordService::class, PasswordService::class);
        $this->app->bind(IFormService::class, FormService::class);
        $this->app->bind(IFormQuestionService::class, FormQuestionService::class);
        $this->app->bind(IFormSubmitService::class, FormSubmitService::class);
        $this->app->bind(ISyncKlasorlerService::class, SyncKlasorlerService::class);
        $this->app->bind(ISyncDosyaHareketService::class, SyncDosyaHareketService::class);
        $this->app->bind(IEDefterDonemlerService::class, EDefterDonemlerService::class);
        $this->app->bind(IEDefterDosyalarService::class, EDefterDosyalarService::class);
        $this->app->bind(IBackupDosyalarService::class, BackupDosyalarService::class);
        $this->app->bind(IFirmalarService::class, FirmalarService::class);

        // Aws Services
        $this->app->bind(IStorageService::class, StorageService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

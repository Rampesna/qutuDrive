<?php

namespace App\Providers;

use App\Interfaces\AwsS3\IStorageService;
use App\Interfaces\Eloquent\IBoardService;
use App\Interfaces\Eloquent\IDirectoryService;
use App\Interfaces\Eloquent\IFileService;
use App\Interfaces\Eloquent\INoteService;
use App\Interfaces\Eloquent\IPasswordResetService;
use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use App\Interfaces\Eloquent\IProjectService;
use App\Interfaces\Eloquent\IProjectStatusService;
use App\Interfaces\Eloquent\ISubTaskService;
use App\Interfaces\Eloquent\ITaskPriorityService;
use App\Interfaces\Eloquent\ITaskService;
use App\Interfaces\Eloquent\IUserService;
use App\Services\AwsS3\StorageService;
use App\Services\Eloquent\BoardService;
use App\Services\Eloquent\DirectoryService;
use App\Services\Eloquent\FileService;
use App\Services\Eloquent\PasswordResetService;
use App\Services\Eloquent\PersonalAccessTokenService;
use App\Services\Eloquent\ProjectService;
use App\Services\Eloquent\ProjectStatusService;
use App\Services\Eloquent\SubTaskService;
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

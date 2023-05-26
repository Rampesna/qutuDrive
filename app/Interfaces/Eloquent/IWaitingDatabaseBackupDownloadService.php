<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

/**
 *
 */
interface IWaitingDatabaseBackupDownloadService extends IEloquentService
{
    /**
     * @param int $userId
     * @param int|null $statusId
     *
     * @return ServiceResponse
     */
    public function getByUserId(
        int      $userId,
        int|null $statusId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function cancel(
        int $userId,
        int $id
    ): ServiceResponse;

    /**
     * @param int $companyId
     * @param int $backupdosyalarId
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function create(
        int $companyId,
        int $backupdosyalarId,
        int $userId,
    ): ServiceResponse;
}

<?php

namespace App\Services\Eloquent;


use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IWaitingDatabaseBackupDownloadService;
use App\Models\Eloquent\WaitingDatabaseBackupDownload;

class WaitingDatabaseBackupDownloadService implements IWaitingDatabaseBackupDownloadService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All Waiting Database Backup Downloads',
            200,
            WaitingDatabaseBackupDownload::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $waitingDatabaseBackupDownload = WaitingDatabaseBackupDownload::find($id);
        if ($waitingDatabaseBackupDownload) {
            return new ServiceResponse(
                true,
                'Waiting Database Backup Download',
                200,
                $waitingDatabaseBackupDownload
            );
        } else {
            return new ServiceResponse(
                false,
                'Waiting Database Backup Download not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $waitingDatabaseBackupDownload = WaitingDatabaseBackupDownload::find($id);
        if ($waitingDatabaseBackupDownload) {
            $waitingDatabaseBackupDownload->delete();
            return new ServiceResponse(
                true,
                'Waiting Database Backup Download deleted',
                200,
                null
            );
        } else {
            return new ServiceResponse(
                false,
                'Waiting Database Backup Download not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $userId
     * @param int|null $statusId
     *
     * @return ServiceResponse
     */
    public function getByUserId(
        int      $userId,
        int|null $statusId
    ): ServiceResponse
    {
        $waitingDatabaseBackupDownloads = WaitingDatabaseBackupDownload::with([
            'backupdosyalar'
        ])->where('user_id', $userId);

        if ($statusId) {
            $waitingDatabaseBackupDownloads = $waitingDatabaseBackupDownloads->where('status_id', $statusId);
        }

        return new ServiceResponse(
            true,
            'Waiting Database Backup Downloads',
            200,
            $waitingDatabaseBackupDownloads->get()
        );
    }

    /**
     * @param int $userId
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function cancel(
        int $userId,
        int $id
    ): ServiceResponse
    {
        $waitingDatabaseBackupDownload = WaitingDatabaseBackupDownload::find($id);
        if ($waitingDatabaseBackupDownload) {
            if ($waitingDatabaseBackupDownload->user_id == $userId) {
                $waitingDatabaseBackupDownload->status_id = 5;
                $waitingDatabaseBackupDownload->save();

                return new ServiceResponse(
                    true,
                    'Waiting Database Backup Download canceled',
                    200,
                    null
                );
            } else {
                return new ServiceResponse(
                    false,
                    'Waiting Database Backup Download not found',
                    404,
                    null
                );
            }
        } else {
            return new ServiceResponse(
                false,
                'Waiting Database Backup Download not found',
                404,
                null
            );
        }
    }

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
    ): ServiceResponse
    {
        $waitingDatabaseBackupDownload = new WaitingDatabaseBackupDownload;
        $waitingDatabaseBackupDownload->company_id = $companyId;
        $waitingDatabaseBackupDownload->backupdosyalar_id = $backupdosyalarId;
        $waitingDatabaseBackupDownload->user_id = $userId;
        $waitingDatabaseBackupDownload->status_id = 1;
        $waitingDatabaseBackupDownload->save();

        return new ServiceResponse(
            true,
            'Waiting Database Backup Download created',
            201,
            $waitingDatabaseBackupDownload
        );
    }
}

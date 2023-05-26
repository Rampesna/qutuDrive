<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\BackupDosyalarController\GetByCompanyIdRequest;
use App\Http\Requests\Api\User\BackupDosyalarController\GetUsageRequest;
use App\Http\Requests\Api\User\BackupDosyalarController\DownloadSingleFileRequest;
use App\Interfaces\AwsS3\IStorageService;
use App\Interfaces\Eloquent\IBackupDosyalarService;
use App\Interfaces\Eloquent\IWaitingDatabaseBackupDownloadService;
use App\Models\Eloquent\Firmalar;

class BackupDosyalarController extends Controller
{
    use HttpResponse;

    /**
     * @var $backupDosyalarService
     */
    private $backupDosyalarService;

    public function __construct(IBackupDosyalarService $backupDosyalarService)
    {
        $this->backupDosyalarService = $backupDosyalarService;
    }

    /**
     * @param GetByCompanyIdRequest $request
     */
    public function getByCompanyId(GetByCompanyIdRequest $request)
    {
        $response = $this->backupDosyalarService->getByCompanyId(
            $request->companyId,
            $request->keyword
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetUsageRequest $request
     */
    public function getUsage(GetUsageRequest $request)
    {
        $response = $this->backupDosyalarService->getUsage(
            $request->companyId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DownloadSingleFileRequest $request
     */
    public function downloadSingleFile(DownloadSingleFileRequest $request)
    {
        $storageService = app()->make(IStorageService::class);
        $response = $this->backupDosyalarService->getById(
            $request->backupDosyalarId
        );

        if ($response->isSuccess()) {
            if ($response->getData()->YEDEKDOSYAPARCASAYISI == 1) {
                $fileUrlResponse = $storageService->downloadSingleFile(
                    $response->getData()->ISEMRIBASLIKID . '.zip'
                );

                return $this->httpResponse(
                    $fileUrlResponse->getMessage(),
                    $fileUrlResponse->getStatusCode(),
                    $fileUrlResponse->getData(),
                    $fileUrlResponse->isSuccess()
                );
            } else {
                $waitingDatabaseBackupDownloadService = app()->make(IWaitingDatabaseBackupDownloadService::class);
                $company = Firmalar::where('APIKEY', $response->getData()->FIRMAAPIKEY)->first();

                $createResponse = $waitingDatabaseBackupDownloadService->create(
                    $company->ID,
                    $response->getData()->ID,
                    $request->user()->ID
                );

                return $this->httpResponse(
                    $createResponse->getMessage(),
                    $createResponse->getStatusCode(),
                    $createResponse->getData(),
                    $createResponse->isSuccess()
                );
            }
        } else {
            return $this->httpResponse(
                $response->getMessage(),
                $response->getStatusCode(),
                $response->getData(),
                $response->isSuccess()
            );
        }
    }
}

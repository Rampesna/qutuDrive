<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\SyncDosyaHareketController\DownloadSingleFileRequest;
use App\Http\Requests\Api\User\SyncDosyaHareketController\GetBySunucuKlasorIdRequest;
use App\Http\Requests\Api\User\SyncDosyaHareketController\GetUsageRequest;
use App\Interfaces\AwsS3\IStorageService;
use App\Interfaces\Eloquent\ISyncDosyaHareketService;

class SyncDosyaHareketController extends Controller
{
    use HttpResponse;

    /**
     * @var $syncdosyahareketService
     */
    private $syncdosyahareketService;

    public function __construct(ISyncDosyaHareketService $syncdosyahareketService)
    {
        $this->syncdosyahareketService = $syncdosyahareketService;
    }

    /**
     * @param GetBySunucuKlasorIdRequest $request
     */
    public function getBySunucuKlasorId(GetBySunucuKlasorIdRequest $request)
    {
        $response = $this->syncdosyahareketService->getBySunucuKlasorId(
            $request->sunucuKlasorId
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
        $response = $this->syncdosyahareketService->getUsage(
            $request->companyId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /*
     * @param DownloadSingleFileRequest $request
     * */
    public function downloadSingleFile(DownloadSingleFileRequest $request)
    {
        $storageService = app()->make(IStorageService::class);
        $response = $this->syncdosyahareketService->getByUuId(
            $request->fileId
        );

        if ($response->isSuccess()) {
            $fileUrlResponse = $storageService->downloadSingleFile(
                $response->getData()->ID . $response->getData()->DOSYAUZANTISI
            );

            return $this->httpResponse(
                $fileUrlResponse->getMessage(),
                $fileUrlResponse->getStatusCode(),
                $fileUrlResponse->getData(),
                $fileUrlResponse->isSuccess()
            );
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

<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;

use App\Core\HttpResponse;
use App\Http\Requests\Api\User\WaitingDatabaseBackupDownloadController\CreateRequest;
use App\Http\Requests\Api\User\WaitingDatabaseBackupDownloadController\DeleteRequest;
use App\Http\Requests\Api\User\WaitingDatabaseBackupDownloadController\GetAllRequest;
use App\Http\Requests\Api\User\WaitingDatabaseBackupDownloadController\GetByIdRequest;
use App\Http\Requests\Api\User\WaitingDatabaseBackupDownloadController\GetByUserIdRequest;
use App\Http\Requests\Api\User\WaitingDatabaseBackupDownloadController\CancelRequest;
use App\Interfaces\Eloquent\IWaitingDatabaseBackupDownloadService;

/**
 *
 */
class WaitingDatabaseBackupDownloadController extends Controller
{
    use HttpResponse;

    /**
     * @var $waitingDatabaseBackupDownloadService
     */
    private $waitingDatabaseBackupDownloadService;

    /**
     * @param IWaitingDatabaseBackupDownloadService $waitingDatabaseBackupDownloadService
     */
    public function __construct(IWaitingDatabaseBackupDownloadService $waitingDatabaseBackupDownloadService)
    {
        $this->waitingDatabaseBackupDownloadService = $waitingDatabaseBackupDownloadService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->waitingDatabaseBackupDownloadService->getAll();
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $response = $this->waitingDatabaseBackupDownloadService->getById($request->id);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DeleteRequest $request
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->waitingDatabaseBackupDownloadService->delete($request->id);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByUserIdRequest $request
     */
    public function getByUserId(GetByUserIdRequest $request)
    {
        $response = $this->waitingDatabaseBackupDownloadService->getByUserId(
            $request->user()->ID,
            $request->statusId
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CancelRequest $request
     */
    public function cancel(CancelRequest $request)
    {
        $response = $this->waitingDatabaseBackupDownloadService->cancel(
            $request->user()->ID,
            $request->id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $response = $this->waitingDatabaseBackupDownloadService->create(
            $request->companyId,
            $request->backupdosyalarId,
            $request->userId
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}

<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Interfaces\AwsS3\IStorageService;
use App\Interfaces\Eloquent\IFileService;
use App\Http\Requests\Api\User\FileController\GetAllRequest;
use App\Http\Requests\Api\User\FileController\UploadRequest;
use App\Http\Requests\Api\User\FileController\UploadBatchRequest;
use App\Http\Requests\Api\User\FileController\DownloadRequest;
use App\Http\Requests\Api\User\FileController\GetByIdRequest;
use App\Http\Requests\Api\User\FileController\GetByRelationRequest;
use App\Http\Requests\Api\User\FileController\GetTrashedByRelationRequest;
use App\Http\Requests\Api\User\FileController\UpdateDirectoryIdRequest;
use App\Http\Requests\Api\User\FileController\DeleteRequest;
use App\Http\Requests\Api\User\FileController\DeleteBatchRequest;
use App\Http\Requests\Api\User\FileController\RecoverRequest;
use App\Core\HttpResponse;

class FileController extends Controller
{
    use HttpResponse;

    /**
     * @var $fileService
     */
    private $fileService;

    /**
     * @var $storageService
     */
    private $storageService;

    /**
     * @param IFileService $fileService
     */
    public function __construct(IFileService $fileService, IStorageService $storageService)
    {
        $this->fileService = $fileService;
        $this->storageService = $storageService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $getAllResponse = $this->fileService->getAll();
        if ($getAllResponse->isSuccess()) {
            return $this->success(
                $getAllResponse->getMessage(),
                $getAllResponse->getData(),
                $getAllResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getAllResponse->getMessage(),
                $getAllResponse->getStatusCode()
            );
        }
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $getByIdResponse = $this->fileService->getById(
            $request->id
        );
        if ($getByIdResponse->isSuccess()) {
            return $this->success(
                $getByIdResponse->getMessage(),
                $getByIdResponse->getData(),
                $getByIdResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getByIdResponse->getMessage(),
                $getByIdResponse->getStatusCode()
            );
        }
    }

    /**
     * @param GetByRelationRequest $request
     */
    public function getByRelation(GetByRelationRequest $request)
    {
        $response = $this->fileService->getByRelation(
            $request->directoryId,
            $request->relationId,
            $request->relationType
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param GetTrashedByRelationRequest $request
     */
    public function getTrashedByRelation(GetTrashedByRelationRequest $request)
    {
        $response = $this->fileService->getTrashedByRelation(
            $request->relationId,
            $request->relationType
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param GetByRelationRequest $request
     */
    public function getDatabaseBackups(GetByRelationRequest $request)
    {
        $response = $this->fileService->getDatabaseBackups(
            $request->user()->ID
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param UploadRequest $request
     */
    public function upload(UploadRequest $request)
    {
        $storeResponse = $this->storageService->store(
            $request->file('file'),
            $request->filePath
        );

        if ($storeResponse->isSuccess()) {
            $createResponse = $this->fileService->create(
                $request->user()->ID,
                'App\\Models\\Eloquent\\Kullanicilar',
                $request->file('file')->getClientOriginalName(),
                $request->file('file')->getClientMimeType(),
                $request->icon,
                $request->typeId ?? getFileTypeId($request->file('file')->getClientMimeType()),
                $storeResponse->getData(),
                $request->file('file')->getSize()
            );

            return $this->httpResponse(
                $createResponse->getMessage(),
                $createResponse->getStatusCode(),
                $createResponse->getData(),
                $createResponse->isSuccess()
            );
        } else {
            return $this->httpResponse(
                $storeResponse->getMessage(),
                $storeResponse->getStatusCode(),
                $storeResponse->getData(),
                $storeResponse->isSuccess()
            );
        }
    }

    /**
     * @param UploadBatchRequest $request
     */
    public function uploadBatch(UploadBatchRequest $request)
    {
        foreach ($request->file('files') as $file) {
            $storeResponse = $this->storageService->store(
                $file,
                $request->filePath
            );
            if ($storeResponse->isSuccess()) {
                $createResponse = $this->fileService->create(
                    $request->user()->id,
                    'App\\Models\\Eloquent\\User',
                    $request->relationId,
                    $request->relationType,
                    $file->getClientMimeType(),
                    $request->icon,
                    $file->getClientOriginalName(),
                    $storeResponse->getData()
                );
                if ($createResponse->isSuccess()) {
                    continue;
                } else {
                    return $this->error(
                        $createResponse->getMessage(),
                        $createResponse->getStatusCode()
                    );
                }
            } else {
                return $this->error(
                    $storeResponse->getMessage(),
                    $storeResponse->getStatusCode()
                );
            }
        }

        return $this->success(
            'Files uploaded successfully',
            null
        );
    }

    /**
     * @param DownloadRequest $request
     */
    public function download(DownloadRequest $request)
    {
        $file = $this->fileService->getById(
            $request->id
        );
        if ($file->isSuccess()) {
            $fileFromStorage = $this->storageService->getByKey(
                $file->getData()->path
            );
            if ($fileFromStorage->isSuccess()) {
                header("Content-Type: {$fileFromStorage->getData()['ContentType']}");
                echo $fileFromStorage->getData()['Body'];
                return null;
            } else {
                return $this->error(
                    $fileFromStorage->getMessage(),
                    $fileFromStorage->getStatusCode()
                );
            }
        } else {
            return $this->error(
                $file->getMessage(),
                $file->getStatusCode()
            );
        }
    }

    /**
     * @param UpdateDirectoryIdRequest $request
     */
    public function updateDirectoryId(UpdateDirectoryIdRequest $request)
    {
        $response = $this->fileService->updateDirectoryId(
            $request->directoryId,
            $request->fileIds
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param DeleteRequest $request
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->fileService->delete(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param DeleteBatchRequest $request
     */
    public function deleteBatch(DeleteBatchRequest $request)
    {
        $response = $this->fileService->deleteBatch(
            $request->fileIds
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param RecoverRequest $request
     */
    public function recover(RecoverRequest $request)
    {
        $response = $this->fileService->recover(
            $request->fileIds
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }
}

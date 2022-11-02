<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Interfaces\Eloquent\IDirectoryService;
use App\Http\Requests\Api\User\DirectoryController\GetByParentIdRequest;
use App\Http\Requests\Api\User\DirectoryController\CreateRequest;
use App\Http\Requests\Api\User\DirectoryController\RenameRequest;
use App\Http\Requests\Api\User\DirectoryController\UpdateParentIdRequest;
use App\Http\Requests\Api\User\DirectoryController\DeleteRequest;
use App\Core\HttpResponse;

class DirectoryController extends Controller
{
    use HttpResponse;

    /**
     * @var $directoryService
     */
    private $directoryService;

    /**
     * @param IDirectoryService $directoryService
     */
    public function __construct(IDirectoryService $directoryService)
    {
        $this->directoryService = $directoryService;
    }

    /**
     * @param GetByParentIdRequest $request
     */
    public function getByParentId(GetByParentIdRequest $request)
    {
        $response = $this->directoryService->getByParentId(
            $request->companyId,
            $request->parentId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $response = $this->directoryService->create(
            $request->parentId,
            $request->companyId,
            $request->name
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param RenameRequest $request
     */
    public function rename(RenameRequest $request)
    {
        $response = $this->directoryService->rename(
            $request->id,
            $request->name
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }

    /**
     * @param UpdateParentIdRequest $request
     */
    public function updateParentId(UpdateParentIdRequest $request)
    {
        $response = $this->directoryService->updateParentId(
            $request->parentId,
            $request->directoryIds
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
        $response = $this->directoryService->delete(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData()
        );
    }
}

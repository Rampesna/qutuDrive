<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Interfaces\Eloquent\IDirectoryService;
use App\Http\Requests\Api\User\DirectoryController\GetByParentIdRequest;
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
}

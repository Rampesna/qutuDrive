<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;

use App\Interfaces\Eloquent\IProjectService;
use App\Http\Requests\Api\User\ProjectController\IndexRequest;
use App\Core\Response;

class ProjectController extends Controller
{
    use Response;

    /**
     * @var $projectService
     */
    private $projectService;

    /**
     * @var $passwordResetService
     */
    public function __construct(IProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @param IndexRequest $request
     */
    public function index(IndexRequest $request)
    {
        $response = $this->projectService->index(
            $request->pageIndex,
            $request->pageSize,
            $request->orderBy,
            $request->orderType,
            $request->user()->ID,
            $request->companyId,
            $request->statusId,
            $request->keyword,
            $request->with
        );
        return $this->coreResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}

<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\ProjectStatusController\GetAllRequest;
use App\Interfaces\Eloquent\IProjectStatusService;
use App\Core\HttpResponse;

class ProjectStatusController extends Controller
{
    use HttpResponse;

    /**
     * @var $projectStatusService
     */
    private $projectStatusService;

    /**
     * @param IProjectStatusService $projectStatusService
     */
    public function __construct(IProjectStatusService $projectStatusService)
    {
        $this->projectStatusService = $projectStatusService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->projectStatusService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}

<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Interfaces\Eloquent\ITaskPriorityService;
use App\Http\Requests\Api\User\TaskPriorityController\GetAllRequest;
use App\Core\HttpResponse;

class TaskPriorityController extends Controller
{
    use HttpResponse;

    /**
     * @var $taskPriorityService
     */
    private $taskPriorityService;

    /**
     * @param ITaskPriorityService $taskPriorityService
     */
    public function __construct(ITaskPriorityService $taskPriorityService)
    {
        $this->taskPriorityService = $taskPriorityService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->taskPriorityService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}

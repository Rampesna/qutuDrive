<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Interfaces\Eloquent\ISubTaskService;
use App\Http\Requests\Api\User\SubTaskController\GetByProjectIdRequest;
use App\Http\Requests\Api\User\SubTaskController\GetByProjectIdsRequest;
use App\Http\Requests\Api\User\SubTaskController\CreateRequest;
use App\Http\Requests\Api\User\SubTaskController\UpdateRequest;
use App\Http\Requests\Api\User\SubTaskController\SetCheckedRequest;
use App\Http\Requests\Api\User\SubTaskController\DeleteRequest;
use App\Core\HttpResponse;

class SubTaskController extends Controller
{
    use HttpResponse;

    /**
     * @var $subTaskService
     */
    private $subTaskService;

    /**
     * @param ISubTaskService $subTaskService
     */
    public function __construct(ISubTaskService $subTaskService)
    {
        $this->subTaskService = $subTaskService;
    }

    /**
     * @param GetByProjectIdRequest $request
     */
    public function getByProjectId(GetByProjectIdRequest $request)
    {
        $userProjects = $request->user()->projects()->pluck('id')->toArray();

        if (!in_array($request->projectId, $userProjects)) {
            return $this->httpResponse('Project not found', 404);
        }

        $response = $this->subTaskService->getByProjectId($request->projectId);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByProjectIdsRequest $request
     */
    public function getByProjectIds(GetByProjectIdsRequest $request)
    {
        $userProjects = $request->user()->projects()->pluck('id')->toArray();

        foreach ($request->projectIds as $projectId) {
            if (!in_array($projectId, $userProjects)) {
                return $this->httpResponse('Project not found', 404);
            }
        }

        $response = $this->subTaskService->getByProjectIds($request->projectIds);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $response = $this->subTaskService->create(
            $request->taskId,
            $request->name
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateRequest $request
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->subTaskService->update(
            $request->id,
            $request->name
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SetCheckedRequest $request
     */
    public function setChecked(SetCheckedRequest $request)
    {
        $response = $this->subTaskService->setChecked(
            $request->id,
            $request->checked
        );

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
        $response = $this->subTaskService->delete(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}

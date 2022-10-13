<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Interfaces\Eloquent\IProjectService;
use App\Http\Requests\Api\User\ProjectController\IndexRequest;
use App\Http\Requests\Api\User\ProjectController\GetByIdRequest;
use App\Http\Requests\Api\User\ProjectController\GetAllTasksRequest;
use App\Http\Requests\Api\User\ProjectController\GetSubtasksByProjectIdRequest;
use App\Http\Requests\Api\User\ProjectController\GetBoardsByProjectIdRequest;
use App\Http\Requests\Api\User\ProjectController\GetUsersByProjectIdRequest;
use App\Http\Requests\Api\User\ProjectController\SetUsersByProjectIdRequest;
use App\Http\Requests\Api\User\ProjectController\CreateRequest;
use App\Http\Requests\Api\User\ProjectController\UpdateRequest;
use App\Http\Requests\Api\User\ProjectController\DeleteRequest;
use App\Core\HttpResponse;

class ProjectController extends Controller
{
    use HttpResponse;

    /**
     * @var $projectService
     */
    private $projectService;

    /**
     * @param IProjectService $projectService
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
            $request->statusIds,
            $request->keyword,
            $request->with
        );

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
        $userProjects = $request->user()->projects()->pluck('id')->toArray();

        if (!in_array($request->id, $userProjects)) {
            return $this->httpResponse('Project not found', 404);
        }

        $response = $this->projectService->getById($request->id);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetAllTasksRequest $request
     */
    public function getAllTasks(GetAllTasksRequest $request)
    {
        $userProjects = $request->user()->projects()->pluck('id')->toArray();

        if (!in_array($request->projectId, $userProjects)) {
            return $this->httpResponse('Project not found', 404);
        }

        $response = $this->projectService->getAllTasks(
            $request->projectId,
            $request->management
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetSubtasksByProjectIdRequest $request
     */
    public function getSubtasksByProjectId(GetSubtasksByProjectIdRequest $request)
    {
        $userProjects = $request->user()->projects()->pluck('id')->toArray();

        if (!in_array($request->projectId, $userProjects)) {
            return $this->httpResponse('Project not found', 404);
        }

        $response = $this->projectService->getSubtasksByProjectId($request->projectId);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetBoardsByProjectIdRequest $request
     */
    public function getBoardsByProjectId(GetBoardsByProjectIdRequest $request)
    {
        $userProjects = $request->user()->projects()->pluck('id')->toArray();

        if (!in_array($request->projectId, $userProjects)) {
            return $this->httpResponse('Project not found', 404);
        }

        $response = $this->projectService->getBoardsByProjectId(
            $request->projectId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetUsersByProjectIdRequest $request
     */
    public function getUsersByProjectId(GetUsersByProjectIdRequest $request)
    {
        $response = $this->projectService->getUsersByProjectId(
            $request->projectId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SetUsersByProjectIdRequest $request
     */
    public function setUsersByProjectId(SetUsersByProjectIdRequest $request)
    {
        $response = $this->projectService->setUsersByProjectId(
            $request->projectId,
            $request->userIds
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
     */
    public function create(CreateRequest $request)
    {
        $response = $this->projectService->create(
            $request->companyId,
            $request->name,
            $request->code,
            $request->startDate,
            $request->endDate,
            $request->description
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
        $response = $this->projectService->update(
            $request->id,
            $request->companyId,
            $request->statusId,
            $request->name,
            $request->code,
            $request->startDate,
            $request->endDate,
            $request->description
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
        $response = $this->projectService->delete(
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

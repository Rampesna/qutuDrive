<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\TaskController\GetByIdRequest;
use App\Http\Requests\Api\User\TaskController\GetFilesByIdRequest;
use App\Http\Requests\Api\User\TaskController\GetSubTasksByIdRequest;
use App\Http\Requests\Api\User\TaskController\GetCommentsByIdRequest;
use App\Http\Requests\Api\User\TaskController\CreateRequest;
use App\Http\Requests\Api\User\TaskController\UpdateBoardRequest;
use App\Http\Requests\Api\User\TaskController\UpdateOrderRequest;
use App\Http\Requests\Api\User\TaskController\UpdateByParametersRequest;
use App\Http\Requests\Api\User\TaskController\DeleteRequest;
use App\Interfaces\Eloquent\ITaskService;
use App\Core\HttpResponse;

class TaskController extends Controller
{
    use HttpResponse;

    /**
     * @var $taskService
     */
    private $taskService;

    /**
     * @param ITaskService $taskService
     */
    public function __construct(ITaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $response = $this->taskService->getById($request->id);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetFilesByIdRequest $request
     */
    public function getFilesById(GetFilesByIdRequest $request)
    {
        $response = $this->taskService->getFilesById($request->id);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetSubTasksByIdRequest $request
     */
    public function getSubTasksById(GetSubTasksByIdRequest $request)
    {
        $response = $this->taskService->getSubTasksById($request->id);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetCommentsByIdRequest $request
     */
    public function getCommentsById(GetCommentsByIdRequest $request)
    {
        $response = $this->taskService->getCommentsById($request->id);

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
        $response = $this->taskService->create(
            $request->boardId,
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
     * @param UpdateBoardRequest $request
     */
    public function updateBoard(UpdateBoardRequest $request)
    {
        $response = $this->taskService->updateBoard(
            $request->taskId,
            $request->boardId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateOrderRequest $request
     */
    public function updateOrder(UpdateOrderRequest $request)
    {
        $response = $this->taskService->updateOrder(
            $request->tasks
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateByParametersRequest $request
     */
    public function updateByParameters(UpdateByParametersRequest $request)
    {
        $response = $this->taskService->updateByParameters(
            $request->id,
            $request->parameters
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
        $response = $this->taskService->delete($request->id);

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}

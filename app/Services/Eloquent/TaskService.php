<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\ITaskService;
use App\Models\Eloquent\Task;
use App\Core\ServiceResponse;

class TaskService implements ITaskService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/TaskService.getAll.success'),
            200,
            Task::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $task = Task::find($id);
        if ($task) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.getById.exists'),
                200,
                $task
            );
        }
        return new ServiceResponse(
            false,
            __('ServiceResponse/Eloquent/TaskService.getById.notFound'),
            404,
            null
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $task = $this->getById($id);
        if ($task->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.delete.success'),
                200,
                $task->getData()->delete()
            );
        } else {
            return $task;
        }
    }

    /**
     * @param int $boardId
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function create(
        int    $boardId,
        string $name
    ): ServiceResponse
    {
        $lastTask = Task::where('board_id', $boardId)->orderBy('order', 'desc')->first();
        $task = new Task;
        $task->board_id = $boardId;
        $task->name = $name;
        $task->order = $lastTask ? ($lastTask->order + 1) : 1;
        $task->save();

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/TaskService.create.success'),
            201,
            $task
        );
    }

    /**
     * @param int $taskId
     * @param int $boardId
     *
     * @return ServiceResponse
     */
    public function updateBoard(
        int $taskId,
        int $boardId
    ): ServiceResponse
    {
        $task = $this->getById($taskId);
        if ($task->isSuccess()) {
            $task->getData()->board_id = $boardId;
            $task->getData()->save();
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.updateBoard.success'),
                200,
                $task->getData()
            );
        } else {
            return $task;
        }
    }

    /**
     * @param array $taskList
     *
     * @return ServiceResponse
     */
    public function updateOrder(
        array $taskList
    ): ServiceResponse
    {
        foreach ($taskList as $task) {
            $getTask = $this->getById(intval($task['id']));
            if ($getTask->isSuccess()) {
                $getTask->getData()->order = intval($task['order']);
                $getTask->getData()->save();
            }
        }

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/TaskService.updateOrder.success'),
            200,
            null
        );
    }

    /**
     * @param int $id
     * @param array $parameters
     *
     * @return ServiceResponse
     */
    public function updateByParameters(
        int   $id,
        array $parameters
    ): ServiceResponse
    {
        $task = $this->getById($id);
        if ($task->isSuccess()) {
            foreach ($parameters as $parameter) {
                $task->getData()->{$parameter['attribute']} = $parameter['value'];
            }
            $task->getData()->save();
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.updateByParameters.success'),
                200,
                $task->getData()
            );
        } else {
            return $task;
        }
    }

    /**
     * @param int $taskId
     *
     * @return ServiceResponse
     */
    public function getFilesById(
        int $taskId
    ): ServiceResponse
    {
        $task = $this->getById($taskId);
        if ($task->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.getFilesById.success'),
                200,
                $task->getData()->files
            );
        } else {
            return $task;
        }
    }

    /**
     * @param int $taskId
     *
     * @return ServiceResponse
     */
    public function getSubTasksById(
        int $taskId
    ): ServiceResponse
    {
        $task = $this->getById($taskId);
        if ($task->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.getSubTasksById.success'),
                200,
                $task->getData()->subTasks
            );
        } else {
            return $task;
        }
    }

    /**
     * @param int $taskId
     *
     * @return ServiceResponse
     */
    public function getCommentsById(
        int $taskId
    ): ServiceResponse
    {
        $task = $this->getById($taskId);
        if ($task->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/TaskService.getCommentsById.success'),
                200,
                $task->getData()->comments()->with([
                    'creator'
                ])->get()
            );
        } else {
            return $task;
        }
    }
}

<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\ITaskPriorityService;
use App\Models\Eloquent\TaskPriority;
use App\Core\ServiceResponse;

class TaskPriorityService implements ITaskPriorityService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All task priorities',
            200,
            TaskPriority::all()
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
        $taskPriority = TaskPriority::find($id);
        if ($taskPriority) {
            return new ServiceResponse(
                true,
                'Task priority',
                200,
                $taskPriority
            );
        } else {
            return new ServiceResponse(
                false,
                'Task priority not found',
                404,
                null
            );
        }
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
        $taskPriority = $this->getById($id);
        if ($taskPriority->isSuccess()) {
            return new ServiceResponse(
                true,
                'Task priority deleted',
                200,
                $taskPriority->getData()->delete()
            );
        } else {
            return $taskPriority;
        }
    }

}

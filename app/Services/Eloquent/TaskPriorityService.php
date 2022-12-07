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
            __('ServiceResponse/Eloquent/TaskPriorityService.getAll.success'),
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
                __('ServiceResponse/Eloquent/TaskPriorityService.getById.exists'),
                200,
                $taskPriority
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/TaskPriorityService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/TaskPriorityService.delete.success'),
                200,
                $taskPriority->getData()->delete()
            );
        } else {
            return $taskPriority;
        }
    }

}

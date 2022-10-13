<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\ISubTaskService;
use App\Models\Eloquent\SubTask;
use App\Core\ServiceResponse;

class SubTaskService implements ISubTaskService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All subTasks',
            200,
            SubTask::all()
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
        $subTask = SubTask::find($id);
        if ($subTask) {
            return new ServiceResponse(
                true,
                'SubTask',
                200,
                $subTask
            );
        } else {
            return new ServiceResponse(
                false,
                'SubTask not found',
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
        $subTask = $this->getById($id);
        if ($subTask->isSuccess()) {
            return new ServiceResponse(
                true,
                'SubTask deleted',
                200,
                $subTask->getData()->delete()
            );
        } else {
            return $subTask;
        }
    }

    /**
     * @param int $projectId
     *
     * @return ServiceResponse
     */
    public function getByProjectId(
        int $projectId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'SubTasks',
            200,
            SubTask::where('project_id', $projectId)->get()
        );
    }

    /**
     * @param array $projectIds
     *
     * @return ServiceResponse
     */
    public function getByProjectIds(
        array $projectIds
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'SubTasks',
            200,
            SubTask::whereIn('project_id', $projectIds)->get()
        );
    }

    /**
     * @param int $taskId
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function create(
        int    $taskId,
        string $name
    ): ServiceResponse
    {
        $subTask = new SubTask;
        $subTask->task_id = $taskId;
        $subTask->name = $name;
        $subTask->order = SubTask::where('task_id', $taskId)->count() + 1;
        $subTask->checked = 0;
        $subTask->save();

        return new ServiceResponse(
            true,
            'SubTask created',
            201,
            $subTask
        );
    }

    /**
     * @param int $id
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $name
    ): ServiceResponse
    {
        $subTask = $this->getById($id);
        if ($subTask->isSuccess()) {
            $subTask->getData()->name = $name;
            $subTask->getData()->save();

            return new ServiceResponse(
                true,
                'SubTask updated',
                200,
                $subTask->getData()
            );
        } else {
            return $subTask;
        }
    }

    /**
     * @param int $id
     * @param int $checked
     *
     * @return ServiceResponse
     */
    public function setChecked(
        int $id,
        int $checked
    ): ServiceResponse
    {
        $subTask = $this->getById($id);
        if ($subTask->isSuccess()) {
            $subTask->getData()->checked = $checked;
            $subTask->getData()->save();

            return new ServiceResponse(
                true,
                'SubTask updated',
                200,
                $subTask->getData()
            );
        } else {
            return $subTask;
        }
    }
}

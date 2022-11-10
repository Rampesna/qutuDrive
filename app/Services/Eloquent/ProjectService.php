<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IProjectService;
use App\Models\Eloquent\Kullanicilar;
use App\Models\Eloquent\Project;

class ProjectService implements IProjectService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            '',
            200,
            Project::all()
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
        $project = Project::with([
            'status'
        ])->find($id);
        if ($project) {
            return new ServiceResponse(
                true,
                'Project',
                200,
                $project
            );
        } else {
            return new ServiceResponse(
                false,
                'Project not found',
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
        $project = $this->getById($id);
        if ($project->isSuccess()) {
            return new ServiceResponse(
                true,
                'Project deleted',
                200,
                $project->getData()->delete()
            );
        } else {
            return $project;
        }
    }

    /**
     * @param array $companyIds
     *
     * @return ServiceResponse
     */
    public function getByCompanyIds(
        array $companyIds
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Projects',
            200,
            Project::whereIn('company_id', $companyIds)->get()
        );
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @param string $orderBy
     * @param string $orderType
     * @param int $userId
     * @param int|null $companyId
     * @param array|null $statusId
     * @param string|null $keyword
     * @param array|null $with
     *
     * @return ServiceResponse
     */
    public function index(
        int     $pageIndex,
        int     $pageSize,
        string  $orderBy,
        string  $orderType,
        int     $userId,
        ?int    $companyId = null,
        ?array  $statusIds = null,
        ?string $keyword = null,
        ?array  $with = null
    ): ServiceResponse
    {
        $projects = Project::with($with ?? [])->orderBy($orderBy, $orderType)->whereIn('id', Kullanicilar::find($userId)->projects->pluck('id')->toArray());

        if ($companyId) {
            $projects->where('company_id', $companyId);
        }

        if ($statusIds && count($statusIds) > 0) {
            $projects->whereIn('status_id', $statusIds);
        }

        if ($keyword) {
            $projects->where('name', 'like', "%$keyword%");
        }

        return new ServiceResponse(
            true,
            'Projects',
            200,
            [
                'totalCount' => $projects->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'projects' => $pageSize == -1 ?
                    $projects->get() :
                    $projects->skip($pageSize * $pageIndex)->take($pageSize)->get()
            ]
        );
    }

    /**
     * @param array $projectIds
     * @param array|null $statusIds
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function getByProjectIds(
        array   $projectIds,
        ?array  $statusIds = [],
        ?string $keyword = null
    ): ServiceResponse
    {
        $projects = Project::with([
            'status'
        ])->whereIn('id', $projectIds);

        if ($statusIds && count($statusIds) > 0) {
            $projects->whereIn('status_id', $statusIds);
        }

        if ($keyword) {
            $projects = $projects->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
        }

        return new ServiceResponse(
            true,
            'Projects',
            200,
            $projects->get()
        );
    }

    /**
     * @param int $projectId
     *
     * @return ServiceResponse
     */
    public function getSubtasksByProjectId(
        int $projectId
    ): ServiceResponse
    {
        $project = $this->getById($projectId);
        if ($project->isSuccess()) {
            return new ServiceResponse(
                true,
                'Subtasks',
                200,
                $project->getData()->subtasks()->get()->toArray()
            );
        } else {
            return $project;
        }
    }

    /**
     * @param int $projectId
     *
     * @return ServiceResponse
     */
    public function getBoardsByProjectId(
        int $projectId
    ): ServiceResponse
    {
        $project = $this->getById($projectId);
        if ($project->isSuccess()) {
            return new ServiceResponse(
                true,
                'Subtasks',
                200,
                $project->getData()->boards()->with([
                    'tasks' => function ($tasks) {
                        $tasks->with([
                            'subTasks',
                            'priority'
                        ]);
                    }
                ])->get()->toArray()
            );
        } else {
            return $project;
        }
    }

    /**
     * @param int $projectId
     * @param int $management
     *
     * @return ServiceResponse
     */
    public function getAllTasks(
        int $projectId,
        int $management
    ): ServiceResponse
    {
        $project = $this->getById($projectId);
        if ($project->isSuccess()) {
            return new ServiceResponse(
                true,
                'Project tasks',
                200,
                $project->getData()->tasks()->with([
                    'priority'
                ])->where('management', $management)->get()->toArray()
            );
        } else {
            return $project;
        }
    }

    /**
     * @param int $projectId
     *
     * @return ServiceResponse
     */
    public function getUsersByProjectId(
        int $projectId
    ): ServiceResponse
    {
        $project = $this->getById($projectId);
        if ($project->isSuccess()) {
            return new ServiceResponse(
                true,
                'Users',
                200,
                $project->getData()->users
            );
        } else {
            return $project;
        }
    }

    /**
     * @param int $projectId
     * @param array $userIds
     *
     * @return ServiceResponse
     */
    public function setUsersByProjectId(
        int   $projectId,
        array $userIds
    ): ServiceResponse
    {
        $project = $this->getById($projectId);
        if ($project->isSuccess()) {
            $project->getData()->users()->sync($userIds);
            return new ServiceResponse(
                true,
                'Users',
                200,
                $project->getData()->users
            );
        } else {
            return $project;
        }
    }

    /**
     * @param array $projectIds
     *
     * @return ServiceResponse
     */
    public function getSubtasksByProjectIds(
        array $projectIds
    ): ServiceResponse
    {
        $subtasks = [];

        foreach ($projectIds as $projectId) {
            $projectSubtasks = $this->getSubtasksByProjectId($projectId);
            if ($projectSubtasks->isSuccess()) {
                $subtasks = array_merge($subtasks, $projectSubtasks->getData());
            }
        }

        return new ServiceResponse(
            true,
            'Subtasks',
            200,
            $subtasks
        );
    }

    /**
     * @param int $userId
     * @param int $companyId
     * @param int $statusId
     * @param string $name
     * @param string|null $description
     * @param string|null $startDate
     * @param string|null $endDate
     *
     * @return ServiceResponse
     */
    public function create(
        int     $userId,
        int     $companyId,
        int     $statusId,
        string  $name,
        ?string $description = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): ServiceResponse
    {
        $project = new Project;
        $project->company_id = $companyId;
        $project->status_id = $statusId;
        $project->name = $name;
        $project->description = $description;
        $project->start_date = $startDate;
        $project->end_date = $endDate;
        $project->created_by = $userId;
        $project->last_updated_by = $userId;
        $project->save();

        return new ServiceResponse(
            true,
            'Project created',
            200,
            $project
        );
    }

    /**
     * @param int $id
     * @param int $userId
     * @param int $statusId
     * @param string $name
     * @param string|null $description
     * @param string|null $startDate
     * @param string|null $endDate
     *
     * @return ServiceResponse
     */
    public function update(
        int     $id,
        int     $userId,
        int     $statusId,
        string  $name,
        ?string $description = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): ServiceResponse
    {
        $project = $this->getById($id);
        if ($project->isSuccess()) {
            $project->getData()->status_id = $statusId;
            $project->getData()->name = $name;
            $project->getData()->description = $description;
            $project->getData()->start_date = $startDate;
            $project->getData()->end_date = $endDate;
            $project->getData()->last_updated_by = $userId;
            $project->getData()->save();

            return new ServiceResponse(
                true,
                'Project updated',
                200,
                $project->getData()
            );
        } else {
            return $project;
        }
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function deleteByUser(
        int $id,
        int $userId
    ): ServiceResponse
    {
        $project = $this->getById($id);
        if ($project->isSuccess()) {
            $project->getData()->deleted_by = $userId;
            $project->getData()->save();
            $project->getData()->delete();

            return new ServiceResponse(
                true,
                'Project deleted',
                200,
                null
            );
        } else {
            return $project;
        }
    }
}

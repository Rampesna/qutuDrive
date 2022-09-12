<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IProjectService;
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
            'All projects',
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
        $project = Project::find($id);
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
     * @param int $pageIndex
     * @param int $pageSize
     * @param string $orderBy
     * @param string $orderType
     * @param int $userId
     * @param int|null $companyId
     * @param int|null $statusId
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
        ?int    $statusId = null,
        ?string $keyword = null,
        ?array  $with = null
    ): ServiceResponse
    {
        $projects = Project::with($with ?? [])->orderBy($orderBy, $orderType);

        if ($companyId) {
            $projects->where('company_id', $companyId);
        }

        if ($statusId) {
            $projects->where('status_id', $statusId);
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
}

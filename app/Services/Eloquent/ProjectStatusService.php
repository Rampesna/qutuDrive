<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IProjectStatusService;
use App\Models\Eloquent\ProjectStatus;
use App\Core\ServiceResponse;

class ProjectStatusService implements IProjectStatusService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All project statuses',
            200,
            ProjectStatus::all()
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
        $projectStatus = ProjectStatus::find($id);
        if ($projectStatus) {
            return new ServiceResponse(
                true,
                'Project status',
                200,
                $projectStatus
            );
        } else {
            return new ServiceResponse(
                false,
                'Project status not found',
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
        $projectStatus = $this->getById($id);
        if ($projectStatus->isSuccess()) {
            return new ServiceResponse(
                true,
                'Project status deleted',
                200,
                $projectStatus->getData()->delete()
            );
        } else {
            return $projectStatus;
        }
    }
}

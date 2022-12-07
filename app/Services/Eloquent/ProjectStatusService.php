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
            __('ServiceResponse/Eloquent/ProjectStatusService.getAll.success'),
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
                __('ServiceResponse/Eloquent/ProjectStatusService.getById.exists'),
                200,
                $projectStatus
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/ProjectStatusService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/ProjectStatusService.delete.success'),
                200,
                $projectStatus->getData()->delete()
            );
        } else {
            return $projectStatus;
        }
    }
}

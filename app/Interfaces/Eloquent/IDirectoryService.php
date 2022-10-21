<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IDirectoryService extends IEloquentService
{
    /**
     * @param int $companyId
     * @param int|null $parentId
     *
     * @return ServiceResponse
     */
    public function getByParentId(
        int  $companyId,
        ?int $parentId = null
    ): ServiceResponse;
}

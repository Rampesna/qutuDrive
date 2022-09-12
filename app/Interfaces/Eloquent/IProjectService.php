<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IProjectService extends IEloquentService
{
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
    ): ServiceResponse;
}

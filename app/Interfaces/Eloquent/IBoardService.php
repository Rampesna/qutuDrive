<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IBoardService extends IEloquentService
{
    /**
     * @param array $boards
     *
     * @return ServiceResponse
     */
    public function updateOrder(
        array $boards
    ): ServiceResponse;

    /**
     * @param int $projectId
     * @param string|null $name
     *
     * @return ServiceResponse
     */
    public function create(
        int     $projectId,
        ?string $name
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string|null $name
     *
     * @return ServiceResponse
     */
    public function updateName(
        int     $id,
        ?string $name,
    ): ServiceResponse;
}

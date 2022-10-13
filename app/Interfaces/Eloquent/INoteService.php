<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface INoteService extends IEloquentService
{
    /**
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     *
     * @return ServiceResponse
     */
    public function getByDateBetween(
        int    $userId,
        string $startDate,
        string $endDate
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param string|null $title
     * @param string|null $noteString
     *
     * @return ServiceResponse
     */
    public function create(
        int    $userId,
        string $date,
        string $title = null,
        string $noteString = null
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string|null $title
     * @param string|null $noteString
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $date,
        string $title = null,
        string $noteString = null
    ): ServiceResponse;
}

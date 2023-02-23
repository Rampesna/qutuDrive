<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

/**
 *
 */
interface IVideoService extends IEloquentService
{

    /**
     * @param string $name
     * @param string $url
     * @return ServiceResponse
     */
    public function create(
        string $name,
        string $url,
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @param string $url
     * @return ServiceResponse
     */
    public function update(
        int $id,
        string $name,
        string $url,
    ): ServiceResponse;

}

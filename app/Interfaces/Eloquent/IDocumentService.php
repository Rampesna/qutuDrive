<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

/**
 *
 */
interface IDocumentService extends IEloquentService
{

    /**
     * @param string $name
     * @param string $path
     * @return ServiceResponse
     */
    public function create(
        string $name,
        string $path,
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @return ServiceResponse
     */
    public function update(
        int $id,
        string $name,
         $file,
    ): ServiceResponse;

}

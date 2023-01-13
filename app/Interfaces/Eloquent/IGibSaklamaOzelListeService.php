<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IGibSaklamaOzelListeService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse;

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function create(
        int $companyId
    ): ServiceResponse;
}

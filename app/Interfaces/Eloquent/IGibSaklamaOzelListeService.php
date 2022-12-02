<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IGibSaklamaOzelListeService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse;
}

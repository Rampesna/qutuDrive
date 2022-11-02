<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IEDefterDosyalarService
{
    /**
     * @param string $donemId
     *
     * @return ServiceResponse
     */
    public function getByDonemId(
        string $donemId
    ): ServiceResponse;
}

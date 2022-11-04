<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IEDefterDonemlerService
{
    /**
     * @param int $companyId
     * @param string $year
     * @param string $month
     * @param array $typeIds
     *
     * @return ServiceResponse
     */
    public function getEDefterDonem(
        int    $companyId,
        string $year,
        string $month,
        array  $typeIds
    ): ServiceResponse;
}

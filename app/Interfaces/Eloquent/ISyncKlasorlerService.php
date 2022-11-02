<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface ISyncKlasorlerService extends IEloquentService
{
    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int $companyId
    ): ServiceResponse;
}

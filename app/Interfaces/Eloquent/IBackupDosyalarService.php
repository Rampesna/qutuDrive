<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IBackupDosyalarService
{
    /**
     * @param int $companyId
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int     $companyId,
        ?string $keyword = null
    ): ServiceResponse;

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     * */
    public function getUsage(
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     * */
    public function getById(
        int $id
    ): ServiceResponse;
}

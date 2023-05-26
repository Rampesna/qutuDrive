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

    /**
     * @param int $companyId
     *
     * return ServiceResponse
     * */
    public function getUsage(
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $companyId
     * @param mixed $userApiKey
     * @param mixed $uploadedFile
     *
     * return ServiceResponse
     * */
    public function singleELedgerUpload(
        int   $companyId,
        mixed $userApiKey,
        mixed $uploadedFile
    ): ServiceResponse;
}

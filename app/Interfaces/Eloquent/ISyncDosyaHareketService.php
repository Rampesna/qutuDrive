<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface ISyncDosyaHareketService extends IEloquentService
{
    /**
     * @param string $sunucuKlasorId
     *
     * @return ServiceResponse
     */
    public function getBySunucuKlasorId(
        string $sunucuKlasorId
    ): ServiceResponse;

    /*
     * @param int $companyId
     *
     * return ServiceResponse
     * */
    public function getUsage(
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getByUuId(
        string $id
    ): ServiceResponse;
}

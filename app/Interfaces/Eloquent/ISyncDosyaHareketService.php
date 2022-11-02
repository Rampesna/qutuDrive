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
}

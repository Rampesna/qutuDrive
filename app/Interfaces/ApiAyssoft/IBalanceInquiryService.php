<?php

namespace App\Interfaces\ApiAyssoft;

use App\Core\ServiceResponse;

interface IBalanceInquiryService
{
    /*
     * @param string $TaxNr
     * @param string $Product
     *
     * @return ServiceResponse
     * */
    public function Index(
        string $TaxNr,
        string $Product
    ): ServiceResponse;
}

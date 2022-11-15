<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IFirmaPaketleriService;
use App\Models\Eloquent\Firmalar;

class FirmaPaketleriService implements IFirmaPaketleriService
{
    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int $companyId
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            return new ServiceResponse(
                true,
                'Company packages',
                200,
                $company->packages
            );
        } else {
            return new ServiceResponse(
                false,
                'Company not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {

    }

    /**
     * @param int $companyId
     * @param string $packageCode
     * @param string $packageName
     * @param string $packageSize
     * @param string $packagePrice
     * @param string $startDate
     * @param string $endDate
     * @param int $status
     * @param int $paymentType
     *
     * @return ServiceResponse
     */
    public function create(
        int    $companyId,
        string $packageCode,
        string $packageName,
        string $packageSize,
        string $packagePrice,
        string $startDate,
        string $endDate,
        int    $status,
        int    $paymentType
    ): ServiceResponse
    {

    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {

    }
}

<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IFirmaPaketleriService
{
    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse;

    /**
     * @param int $companyId
     * @param int $packageId
     * @param float $packagePrice
     * @param string $startDate
     * @param string $endDate
     * @param int $status
     * @param int $paymentType
     *
     * @return ServiceResponse
     */
    public function create(
        int    $companyId,
        int    $packageId,
        float  $packagePrice,
        string $startDate,
        string $endDate,
        int    $status,
        int    $paymentType
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse;

    /*
     * @param int $companyId
     *
     * return ServiceResponse
     * */
    public function getUsage(
        int $companyId
    ): ServiceResponse;
}
